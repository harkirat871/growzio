<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    private const SEARCH_SUGGESTIONS_LIMIT = 6;
    /**
     * Display a listing of the products.
     * Returns JSON for AJAX (infinite scroll), Blade view otherwise.
     */
    public function index(Request $request): View|JsonResponse
    {
        $sort = $this->validSort($request->input('sort'));
        $query = Product::with('category');
        $query = Product::applyListingSort($query, $sort);
        $products = $query->simplePaginate(20)->appends($request->only(['sort']));

        [$rootCategories, ] = $this->buildCategoryTree();
        $categories = $rootCategories;

        if ($request->ajax() || $request->wantsJson()) {
            return $this->productsJsonResponse($products);
        }

        return view('products.index', compact('products', 'categories', 'sort'));
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product): View
    {
        $product->load('category');

        $categoryIds = array_values(array_filter(array_map('intval', [
            $product->category_id,
            $product->category_2_id,
            $product->category_3_id,
            $product->category_4_id,
        ])));

        $youMayAlsoLike = collect();
        if (! empty($categoryIds)) {
            $idsList = implode(',', $categoryIds);
            $youMayAlsoLike = Product::where('id', '!=', $product->id)
                ->where(function ($q) use ($categoryIds) {
                    $q->whereIn('category_id', $categoryIds)
                        ->orWhereIn('category_2_id', $categoryIds)
                        ->orWhereIn('category_3_id', $categoryIds)
                        ->orWhereIn('category_4_id', $categoryIds);
                })
                ->with('category')
                ->orderByRaw("(CASE WHEN category_2_id IN ($idsList) OR category_3_id IN ($idsList) OR category_4_id IN ($idsList) THEN 1 ELSE 0 END) DESC")
                ->orderByRaw("(CASE WHEN category_id IN ($idsList) THEN 1 ELSE 0 END) DESC")
                ->orderByRaw('RAND()')
                ->limit(12)
                ->get();
        }

        return view('products.show', compact('product', 'youMayAlsoLike'));
    }

    /**
     * Display products filtered by category.
     * Returns JSON for AJAX (infinite scroll), Blade view otherwise.
     */
    public function byCategory(Request $request, Category $category): View|JsonResponse
    {
        $sort = $this->validSort($request->input('sort'));
        $categoryId = $category->id;
        $query = Product::where(function ($q) use ($categoryId) {
            $q->where('category_id', $categoryId)
                ->orWhere('category_2_id', $categoryId)
                ->orWhere('category_3_id', $categoryId)
                ->orWhere('category_4_id', $categoryId);
        })->with('category');
        $query = Product::applyListingSort($query, $sort);
        $categoryProductCount = (clone $query)->count();
        $products = $query->simplePaginate(20)->appends($request->only(['sort']));

        [, $categoriesById] = $this->buildCategoryTree();
        $categories = isset($categoriesById[$category->id])
            ? $categoriesById[$category->id]->children
            : collect();

        if ($request->ajax() || $request->wantsJson()) {
            return $this->productsJsonResponse($products);
        }

        return view('products.index', compact('products', 'categories', 'category', 'sort', 'categoryProductCount'));
    }

    /**
     * Build category tree (active only, with product counts).
     * Returns [rootCategories, categoriesById].
     */
    private function buildCategoryTree(): array
    {
        $all = Category::active()
            ->withProductsCountAllSlots()
            ->orderBy('name')
            ->get()
            ->keyBy('id');

        $roots = $all->filter(fn ($c) => $c->parent_id === null)->sortBy('name')->values();

        foreach ($all as $cat) {
            if ($cat->parent_id !== null && isset($all[$cat->parent_id])) {
                $parent = $all[$cat->parent_id];
                if (! $parent->relationLoaded('children')) {
                    $parent->setRelation('children', collect());
                }
                $parent->children->push($cat);
            }
        }

        $this->sortCategoryChildren($roots);

        return [$roots, $all];
    }

    private function sortCategoryChildren($categories): void
    {
        foreach ($categories as $cat) {
            if ($cat->relationLoaded('children') && $cat->children->isNotEmpty()) {
                $cat->setRelation('children', $cat->children->sortBy('name')->values());
                $this->sortCategoryChildren($cat->children);
            }
        }
    }

    /**
     * Build JSON response for paginated products (infinite scroll).
     * next_page_url is returned as path + query so the request uses the current origin.
     */
    private function productsJsonResponse($paginator): JsonResponse
    {
        $products = collect($paginator->items())->map(function (Product $product) {
            $imageUrl = $product->image_path ? asset($product->image_path) : null;
            return [
                'id' => $product->id,
                'name' => $product->name,
                'image_path' => $imageUrl,
                'price' => number_format((float) $product->price, 2),
                'category_name' => $product->category?->name,
                'company_part_number' => $product->company_part_number ?? '',
                'show_url' => route('products.show', $product),
                'add_to_cart_url' => route('cart.add', $product),
            ];
        });

        $nextUrl = $paginator->nextPageUrl();
        $nextPageUrl = $nextUrl ? parse_url($nextUrl, PHP_URL_PATH) . (parse_url($nextUrl, PHP_URL_QUERY) ? '?' . parse_url($nextUrl, PHP_URL_QUERY) : '') : null;

        return response()->json([
            'data' => $products,
            'has_more_pages' => $paginator->hasMorePages(),
            'next_page_url' => $nextPageUrl,
        ]);
    }
    /**
     * Autocomplete suggestions for search (debounced on client).
     * Returns top matching products via Meilisearch/Scout.
     */
    public function searchSuggestions(Request $request): JsonResponse
    {
        $q = trim((string) $request->input('q', ''));
        if ($q === '') {
            return response()->json(['data' => []]);
        }

        $query = Product::search($q)->query(fn ($b) => $b->with('category'));
        $products = $query->take(self::SEARCH_SUGGESTIONS_LIMIT)->get();

        $items = $products->map(function (Product $product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'image_path' => $product->image_path ? asset($product->image_path) : null,
                'price' => number_format((float) $product->price, 2),
                'category_name' => $product->category?->name,
                'show_url' => route('products.show', $product),
            ];
        });

        return response()->json(['data' => $items->values()->all()]);
    }

    /**
     * Search results page or JSON for infinite scroll.
     */
    public function searchResults(Request $request): View|JsonResponse|RedirectResponse
    {
        $q = trim((string) $request->input('q', ''));

        if ($q === '') {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['data' => [], 'has_more_pages' => false, 'next_page_url' => null]);
            }
            return redirect()->route('home');
        }

        $page = (int) $request->input('page', 1);
        $perPage = 20;
        $sort = $this->validSort($request->input('sort'));

        $query = Product::buildAdminSearchQuery($q, false, false);
        $query = Product::applyListingSort($query, $sort);

        if ($query instanceof \Laravel\Scout\Builder) {
            $products = $query->paginate($perPage, 'page', $page);
        } else {
            $products = $query->with('category')->paginate($perPage, ['*'], 'page', $page);
        }
        /** @var \Illuminate\Pagination\AbstractPaginator $products */
        $products->getCollection()->load('category');
        $products->appends($request->only(['q', 'sort']));

        $categories = Category::active()
            ->whereNull('parent_id')
            ->orderBy('name')
            ->paginate(12, ['*'], 'category_page');

        if ($request->ajax() || $request->wantsJson()) {
            return $this->productsJsonResponse($products);
        }

        return view('products.index', [
            'products' => $products,
            'categories' => $categories,
            'searchQuery' => $q,
            'sort' => $sort,
        ]);
    }

    /**
     * Return validated sort key for listing (null = default order).
     */
    private function validSort(?string $sort): ?string
    {
        $valid = [
            Product::SORT_PRICE_ASC,
            Product::SORT_PRICE_DESC,
            Product::SORT_BEST_SELLERS,
        ];
        return in_array($sort, $valid, true) ? $sort : null;
    }
}



