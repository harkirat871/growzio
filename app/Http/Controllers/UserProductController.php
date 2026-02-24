<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class UserProductController extends Controller
{
    public function index(Request $request): View
    {
        $products = Product::where('user_id', $request->user()->id)
            ->latest()
            ->paginate(12);

        return view('dashboard.products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::all();
        return view('dashboard.products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'category_name' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $category = Category::whereRaw('LOWER(name) = LOWER(?)', [$validated['category_name']])->first();
        
        if (!$category) {
            return redirect()->back()
                ->withErrors(['category_name' => 'The selected category does not exist.'])
                ->withInput();
        }

        $data = [
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'category_id' => $category->id,
            'user_id' => $request->user()->id,
        ];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image_path'] = $path;
        }

        Product::create($data);

        return Redirect::route('dashboard.products.index')->with('status', 'Product created');
    }

    public function edit(Request $request, Product $product): View
    {
        abort_unless($product->user_id === $request->user()->id, 403);
        $categories = Category::all();
        return view('dashboard.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        abort_unless($product->user_id === $request->user()->id, 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'category_name' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $category = Category::whereRaw('LOWER(name) = LOWER(?)', [$validated['category_name']])->first();
        
        if (!$category) {
            return redirect()->back()
                ->withErrors(['category_name' => 'The selected category does not exist.'])
                ->withInput();
        }

        $data = [
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'category_id' => $category->id,
        ];
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image_path'] = $path;
        }

        $product->update($data);

        return Redirect::route('dashboard.products.index')->with('status', 'Product updated');
    }

    public function destroy(Request $request, Product $product): RedirectResponse
    {
        abort_unless($product->user_id === $request->user()->id, 403);
        $product->delete();
        return Redirect::route('dashboard.products.index')->with('status', 'Product deleted');
    }
}


