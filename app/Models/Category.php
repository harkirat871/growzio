<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use App\Models\Product;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'path',
        'depth',
        'is_active',
        'image_path',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'depth' => 'integer',
    ];

    /**
     * Boot the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $baseSlug = Str::slug($category->name);
                $slug = $baseSlug;
                $counter = 1;
                while (static::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $counter;
                    $counter++;
                }
                $category->slug = $slug;
            }

            if ($category->parent_id) {
                $parent = static::find($category->parent_id);
                if ($parent) {
                    $category->depth = $parent->depth + 1;
                }
            } else {
                $category->depth = 0;
            }
        });

        static::created(function ($category) {
            if ($category->parent_id) {
                $parent = static::find($category->parent_id);
                if ($parent) {
                    $category->path = ($parent->path ? $parent->path : '') . $parent->id . '/';
                } else {
                    $category->path = '';
                }
            } else {
                $category->path = '';
            }
            $category->saveQuietly();
        });

        static::updated(function ($category) {
            if ($category->wasChanged('path')) {
                $oldPath = $category->getOriginal('path') . $category->id . '/';
                $newPath = $category->path . $category->id . '/';
                static::where('path', 'like', $oldPath . '%')
                    ->get()
                    ->each(function ($descendant) use ($oldPath, $newPath) {
                        $descendant->path = str_replace($oldPath, $newPath, $descendant->path);
                        $descendant->depth = substr_count($descendant->path, '/');
                        $descendant->saveQuietly();
                    });
            }
        });
    }

    /**
     * Get the parent category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get the child categories.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Get the products for the category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Add products_count from all four category slots (category_id, category_2_id, category_3_id, category_4_id).
     * Use this instead of withCount('products') when the count should include products in any slot.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithProductsCountAllSlots($query)
    {
        $subQuery = Product::query()
            ->selectRaw('COUNT(*)')
            ->whereColumn('products.category_id', 'categories.id')
            ->orWhereColumn('products.category_2_id', 'categories.id')
            ->orWhereColumn('products.category_3_id', 'categories.id')
            ->orWhereColumn('products.category_4_id', 'categories.id');

        return $query->select('categories.*')->selectSub($subQuery, 'products_count');
    }

    /**
     * Get all descendant IDs including the current category ID.
     *
     * @return array
     */
    public function getDescendantIds(): array
    {
        $ids = [$this->id];
        $pathPattern = ($this->path ? $this->path : '') . $this->id . '/';
        $descendants = static::where('path', 'like', $pathPattern . '%')->pluck('id')->toArray();
        
        return array_merge($ids, $descendants);
    }

    /**
     * Scope a query to only include active categories.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Resolve a category by name (case-insensitive). Returns the category ID or null if not found.
     * Does not create categories; use for CSV import where only existing categories are allowed.
     *
     * @param  string|null  $name
     * @return int|null
     */
    public static function resolveByName(?string $name): ?int
    {
        $name = $name !== null ? trim($name) : '';
        if ($name === '') {
            return null;
        }
        $category = static::whereRaw('LOWER(TRIM(name)) = ?', [strtolower($name)])->first();

        return $category ? $category->id : null;
    }

    /**
     * Get or create the "General" category (used as fallback when a category doesn't exist).
     *
     * @return int
     */
    public static function getOrCreateGeneral(): int
    {
        $category = static::whereRaw('LOWER(TRIM(name)) = ?', ['general'])->first();
        if ($category) {
            return $category->id;
        }
        $category = static::create([
            'name' => 'General',
            'description' => 'Default category for products when specified category does not exist',
        ]);

        return $category->id;
    }
}