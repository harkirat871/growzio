<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProductAdminController extends Controller
{
    public function show(Product $product): View
    {
        return view('admin.products.show', compact('product'));
    }
    public function index(): View
    {
        $products = Product::latest()->simplePaginate(20);
        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'company_part_number' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'product_name_hi' => ['nullable', 'string', 'max:255'],
            'brand_name' => ['nullable', 'string', 'max:255'],
            'local_part_number' => ['nullable', 'string', 'max:255'],
            'company_part_number_substitute' => ['nullable', 'string', 'max:255'],
            'category_2_id' => ['nullable', 'exists:categories,id'],
            'category_3_id' => ['nullable', 'exists:categories,id'],
            'category_4_id' => ['nullable', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'stock' => ['nullable', 'integer', 'min:0'],
            'dlp' => ['nullable', 'numeric', 'min:0'],
            'unit' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $data = [
            'name' => $validated['name'],
            'company_part_number' => $validated['company_part_number'],
            'category_id' => $validated['category_id'],
            'user_id' => auth()->id(),
            'product_name_hi' => $validated['product_name_hi'] ?? null,
            'brand_name' => $validated['brand_name'] ?? null,
            'local_part_number' => $validated['local_part_number'] ?? null,
            'company_part_number_substitute' => $validated['company_part_number_substitute'] ?? null,
            'category_2_id' => $validated['category_2_id'] ?? null,
            'category_3_id' => $validated['category_3_id'] ?? null,
            'category_4_id' => $validated['category_4_id'] ?? null,
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'] ?? null,
            'stock' => $validated['stock'] ?? null,
            'dlp' => $validated['dlp'] ?? null,
            'unit' => $validated['unit'] ?? null,
        ];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image_path'] = $path;
        }

        Product::create($data);

        return Redirect::route('admin.products.index')->with('status', 'Product created');
    }

    public function edit(Product $product): View
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'company_part_number' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'product_name_hi' => ['nullable', 'string', 'max:255'],
            'brand_name' => ['nullable', 'string', 'max:255'],
            'local_part_number' => ['nullable', 'string', 'max:255'],
            'company_part_number_substitute' => ['nullable', 'string', 'max:255'],
            'category_2_id' => ['nullable', 'exists:categories,id'],
            'category_3_id' => ['nullable', 'exists:categories,id'],
            'category_4_id' => ['nullable', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'stock' => ['nullable', 'integer', 'min:0'],
            'dlp' => ['nullable', 'numeric', 'min:0'],
            'unit' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $data = [
            'name' => $validated['name'],
            'company_part_number' => $validated['company_part_number'],
            'category_id' => $validated['category_id'],
            'product_name_hi' => $validated['product_name_hi'] ?? null,
            'brand_name' => $validated['brand_name'] ?? null,
            'local_part_number' => $validated['local_part_number'] ?? null,
            'company_part_number_substitute' => $validated['company_part_number_substitute'] ?? null,
            'category_2_id' => $validated['category_2_id'] ?? null,
            'category_3_id' => $validated['category_3_id'] ?? null,
            'category_4_id' => $validated['category_4_id'] ?? null,
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'] ?? null,
            'stock' => $validated['stock'] ?? null,
            'dlp' => $validated['dlp'] ?? null,
            'unit' => $validated['unit'] ?? null,
        ];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image_path'] = $path;
        }

        $product->update($data);

        return Redirect::route('admin.products.index')->with('status', 'Product updated');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
        return Redirect::route('admin.products.index')->with('status', 'Product deleted');
    }
}


