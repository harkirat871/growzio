<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;
use Illuminate\Support\Arr;

class Product extends Model
{
    use HasFactory, Searchable;

    protected static function booted(): void
    {
        // Delete related order items first so DB foreign key (restrictOnDelete) does not block product delete
        static::deleting(function (Product $product) {
            $product->orderItems()->delete();
        });
    }
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'search_keywords',
        'product_name_hi',
        'brand_name',
        'local_part_number',
        'company_part_number',
        'company_part_number_substitute',
        'price',
        'dlp',
        'unit',
        'stock',
        'image_path',
        'user_id',
        'category_id',
        'category_2_id',
        'category_3_id',
        'category_4_id',
        'last_sold_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'dlp' => 'decimal:2',
            'last_sold_at' => 'datetime',
        ];
    }

    /**
     * Get the user that owns the product.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the primary category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the second category (optional).
     */
    public function category2(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_2_id');
    }

    /**
     * Get the third category (optional).
     */
    public function category3(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_3_id');
    }

    /**
     * Get the fourth category (optional).
     */
    public function category4(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_4_id');
    }

    /**
     * Get the order items for the product.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /** Threshold below which stock is considered "low" (only when stock is tracked, i.e. not null). */
    public const LOW_STOCK_THRESHOLD = 4;

    /**
     * Scope: products that have stock tracked (not null) and stock is at or below threshold.
     */
    public function scopeLowStock($query)
    {
        return $query->whereNotNull('stock')->where('stock', '<=', self::LOW_STOCK_THRESHOLD);
    }

    /**
     * Whether this product has low stock (stock is tracked and <= threshold).
     */
    public function isLowStock(): bool
    {
        return $this->stock !== null && (int) $this->stock <= self::LOW_STOCK_THRESHOLD;
    }

    /** Number of days without a sale after which a product is considered "dead stock". */
    public const DEAD_STOCK_DAYS = 45;

    /**
     * Scope: dead stock — never sold (last_sold_at is null) or last sold more than $days days ago.
     * Uses only the cached last_sold_at column; no joins or relationship queries.
     */
    public function scopeDeadStock($query, ?int $days = null)
    {
        $days = $days ?? self::DEAD_STOCK_DAYS;
        $cutoff = now()->subDays($days);

        return $query->where(function ($q) use ($cutoff) {
            $q->whereNull('last_sold_at')
              ->orWhere('last_sold_at', '<', $cutoff);
        });
    }

    /**
     * Explicit Meilisearch index name so it is consistent across environments.
     */
    public function searchableAs(): string
    {
        return 'products_index';
    }

    /**
     * Build the searchable representation of the product for Meilisearch.
     *
     * Only include fields relevant for search & filtering:
     * - name / product_name_hi / brand & part numbers / search_keywords
     * - flattened category names in a "categories" field
     * - ids and numeric fields required for filters (categories, stock, price)
     */
    public function toSearchableArray(): array
    {
        // Ensure category relationships are available without blowing up if missing.
        $this->loadMissing(['category', 'category2', 'category3', 'category4']);

        $categoryNames = collect([
                $this->category?->name,
                $this->category2?->name,
                $this->category3?->name,
                $this->category4?->name,
            ])
            ->filter(fn ($name) => $name !== null && $name !== '')
            ->unique()
            ->values()
            ->all();

        return [
            'id' => $this->id,

            // Core search fields (high priority)
            'name' => (string) ($this->name ?? ''),
            'product_name_hi' => (string) ($this->product_name_hi ?? ''),
            'company_part_number' => (string) ($this->company_part_number ?? ''),
            'local_part_number' => (string) ($this->local_part_number ?? ''),
            'company_part_number_substitute' => (string) ($this->company_part_number_substitute ?? ''),
            'brand_name' => (string) ($this->brand_name ?? ''),

            // Additional keyword field for manual boosts / synonyms
            'search_keywords' => (string) ($this->search_keywords ?? ''),

            // All category names (for searching by category text)
            'categories' => $categoryNames,

            // Fields used as filters / sort in Meilisearch
            'category_id' => $this->category_id,
            'category_2_id' => $this->category_2_id,
            'category_3_id' => $this->category_3_id,
            'category_4_id' => $this->category_4_id,
            // Numeric types so Meilisearch sorts by value, not lexicographically (e.g. 160 before 1550).
            'stock' => $this->stock !== null ? (int) $this->stock : null,
            'price' => $this->price !== null && $this->price !== '' ? (float) $this->price : null,
            'last_sold_at' => $this->last_sold_at?->timestamp,
            'created_at' => $this->created_at?->timestamp,
        ];
    }

    /** Valid sort keys for public listing (index, category, search). */
    public const SORT_PRICE_ASC = 'price_asc';
    public const SORT_PRICE_DESC = 'price_desc';
    public const SORT_BEST_SELLERS = 'best_sellers';

    /**
     * Apply listing sort to a builder (Eloquent or Scout). Efficient: uses DB/index order, no products removed.
     *
     * @param \Illuminate\Database\Eloquent\Builder|\Laravel\Scout\Builder $builder
     * @param string|null $sort One of SORT_PRICE_ASC, SORT_PRICE_DESC, SORT_BEST_SELLERS, or null for default
     * @return \Illuminate\Database\Eloquent\Builder|\Laravel\Scout\Builder
     */
    public static function applyListingSort($builder, ?string $sort)
    {
        switch ($sort) {
            case self::SORT_PRICE_ASC:
                return $builder->orderBy('price', 'asc');
            case self::SORT_PRICE_DESC:
                return $builder->orderBy('price', 'desc');
            case self::SORT_BEST_SELLERS:
                return $builder->orderBy('last_sold_at', 'desc');
            default:
                return $builder->latest();
        }
    }

    /**
     * Build the shared product search / listing query used by the admin products index.
     *
     * This is the single source of truth for product search logic and is reused by
     * both the admin products index and the public JSON search endpoint.
     *
     * - When $searchQuery is non-empty, returns a Laravel Scout Builder (Product::search())
     *   with the same low-stock / dead-stock filtering logic used by the admin index.
     * - When $searchQuery is empty, returns a plain Eloquent\Builder with the same
     *   base query (including low-stock / dead-stock scopes). Order is applied by callers via applyListingSort().
     *
     * Callers are responsible for choosing the appropriate pagination method
     * (simplePaginate vs paginate) and per-page / page parameters.
     *
     * @param string $searchQuery
     * @param bool   $lowStockOnly
     * @param bool   $deadStockOnly
     * @return \Laravel\Scout\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public static function buildAdminSearchQuery(string $searchQuery, bool $lowStockOnly = false, bool $deadStockOnly = false)
    {
        // Base query used when there is no full-text search term (no order here; caller applies sort).
        $baseQuery = static::query();

        if ($lowStockOnly) {
            $baseQuery->lowStock();
        }

        if ($deadStockOnly) {
            $baseQuery->deadStock();
        }

        // When a search term is present, delegate to Laravel Scout (full-text search)
        // with the same low-stock / dead-stock constraints as the admin index.
        if ($searchQuery !== '') {
            return static::search($searchQuery)
                ->query(function ($builder) use ($lowStockOnly, $deadStockOnly) {
                    if ($lowStockOnly) {
                        $builder->lowStock();
                    }

                    if ($deadStockOnly) {
                        $builder->deadStock();
                    }

                    return $builder;
                });
        }

        // No search term: return the filtered Eloquent\Builder.
        return $baseQuery;
    }
}


