<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * When query is present, uses Laravel Scout for full-text search.
     * Returns JSON for AJAX (infinite scroll), Blade view otherwise.
     */
    public function index(Request $request): View|JsonResponse
    {
        $searchQuery = $request->input('q', '');
        $searchQuery = is_string($searchQuery) ? trim($searchQuery) : '';
        $lowStockOnly = $request->boolean('low_stock');
        $deadStockOnly = $request->boolean('dead_stock');

        // Shared search / listing query (single source of truth).
        $query = Product::buildAdminSearchQuery($searchQuery, $lowStockOnly, $deadStockOnly);

        // Preserve existing admin pagination behavior (simplePaginate + withQueryString).
        $products = $query->simplePaginate(20)->withQueryString();

        if ($request->ajax() || $request->wantsJson()) {
            return $this->adminProductsJsonResponse($products);
        }

        return view('admin.products.index', compact('products', 'searchQuery', 'lowStockOnly', 'deadStockOnly'));
    }

    /**
     * JSON response for admin products list (infinite scroll).
     */
    private function adminProductsJsonResponse($paginator): JsonResponse
    {
        $products = collect($paginator->items())->map(function (Product $product) {
            return [
                'id' => $product->id,
                'name' => e($product->name),
                'price' => '₹' . number_format((float) $product->price, 2),
                'stock' => (int) $product->stock,
                'edit_url' => route('admin.products.edit', $product),
                'destroy_url' => route('admin.products.destroy', $product),
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
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Resolve category by name (case-insensitive). Returns existing category or creates one.
     * Prevents duplicate categories from casing differences.
     */
    private function resolveCategoryId(?string $name): ?int
    {
        $name = $name !== null ? trim($name) : '';
        if ($name === '') {
            return null;
        }
        $existing = Category::whereRaw('LOWER(name) = ?', [strtolower($name)])->first();
        if ($existing) {
            return $existing->id;
        }
        $category = Category::create(['name' => $name]);
        return $category->id;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'company_part_number' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'product_name_hi' => ['nullable', 'string', 'max:255'],
            'brand_name' => ['nullable', 'string', 'max:255'],
            'local_part_number' => ['nullable', 'string', 'max:255'],
            'company_part_number_substitute' => ['nullable', 'string', 'max:255'],
            'category_2' => ['nullable', 'string', 'max:255'],
            'category_3' => ['nullable', 'string', 'max:255'],
            'category_4' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'stock' => ['nullable', 'integer', 'min:0'],
            'dlp' => ['nullable', 'numeric', 'min:0'],
            'unit' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $productData = [
            'name' => $validated['name'],
            'company_part_number' => $validated['company_part_number'],
            'category_id' => $this->resolveCategoryId($validated['category']),
            'user_id' => auth()->id(),
            'product_name_hi' => $validated['product_name_hi'] ?? null,
            'brand_name' => $validated['brand_name'] ?? null,
            'local_part_number' => $validated['local_part_number'] ?? null,
            'company_part_number_substitute' => $validated['company_part_number_substitute'] ?? null,
            'category_2_id' => $this->resolveCategoryId($validated['category_2'] ?? null),
            'category_3_id' => $this->resolveCategoryId($validated['category_3'] ?? null),
            'category_4_id' => $this->resolveCategoryId($validated['category_4'] ?? null),
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'] ?? null,
            'stock' => $validated['stock'] ?? null,
            'dlp' => $validated['dlp'] ?? null,
            'unit' => $validated['unit'] ?? null,
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('products'), $imageName);
            $productData['image_path'] = 'products/' . $imageName;
        }

        Product::create($productData);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): View
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        $product->load(['category', 'category2', 'category3', 'category4']);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'company_part_number' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'product_name_hi' => ['nullable', 'string', 'max:255'],
            'brand_name' => ['nullable', 'string', 'max:255'],
            'local_part_number' => ['nullable', 'string', 'max:255'],
            'company_part_number_substitute' => ['nullable', 'string', 'max:255'],
            'category_2' => ['nullable', 'string', 'max:255'],
            'category_3' => ['nullable', 'string', 'max:255'],
            'category_4' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'stock' => ['nullable', 'integer', 'min:0'],
            'dlp' => ['nullable', 'numeric', 'min:0'],
            'unit' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $productData = [
            'name' => $validated['name'],
            'company_part_number' => $validated['company_part_number'],
            'category_id' => $this->resolveCategoryId($validated['category']),
            'product_name_hi' => $validated['product_name_hi'] ?? null,
            'brand_name' => $validated['brand_name'] ?? null,
            'local_part_number' => $validated['local_part_number'] ?? null,
            'company_part_number_substitute' => $validated['company_part_number_substitute'] ?? null,
            'category_2_id' => $this->resolveCategoryId($validated['category_2'] ?? null),
            'category_3_id' => $this->resolveCategoryId($validated['category_3'] ?? null),
            'category_4_id' => $this->resolveCategoryId($validated['category_4'] ?? null),
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'] ?? null,
            'stock' => $validated['stock'] ?? null,
            'dlp' => $validated['dlp'] ?? null,
            'unit' => $validated['unit'] ?? null,
        ];

        if ($request->hasFile('image')) {
            if ($product->image_path && file_exists(public_path($product->image_path))) {
                unlink(public_path($product->image_path));
            }
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('products'), $imageName);
            $productData['image_path'] = 'products/' . $imageName;
        }

        $product->update($productData);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Show confirmation page for deleting all products.
     */
    public function destroyAllConfirm(): View
    {
        $productCount = Product::count();

        return view('admin.products.destroy-all-confirm', compact('productCount'));
    }

    /**
     * Delete all products (and their order items). Irreversible.
     */
    public function destroyAll(): RedirectResponse
    {
        DB::transaction(function () {
            OrderItem::query()->delete();
            Product::query()->delete();
        });

        return redirect()->route('admin.products.index')
            ->with('success', 'All products have been permanently deleted. This action cannot be undone.');
    }
}
