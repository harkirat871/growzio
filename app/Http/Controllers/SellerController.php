<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SellerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('seller');
    }

    /**
     * Update order status (for seller's orders)
     */
    public function updateOrderStatus(Request $request, Order $order)
    {
        // Only allow if the seller owns at least one product in this order
        $hasProduct = $order->items->contains(function($item) {
            return $item->product && $item->product->user_id == Auth::id();
        });
        if (!$hasProduct) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|string|in:pending,processing,shipped,delivered,cancelled',
        ]);
        $order->status = $request->status;
        $order->save();
        return redirect()->back()->with('status', 'Order status updated!');
    }

    /**
     * Show seller dashboard
     */
    public function dashboard(): View
    {
        $user = Auth::user();
        $products = Product::where('user_id', $user->id)->latest()->simplePaginate(10);
        $orders = Order::whereHas('items.product', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with('items.product')->latest()->simplePaginate(10);
        
        $totalProducts = Product::where('user_id', $user->id)->count();
        $totalSales = Order::whereHas('items.product', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->sum('total');
        $lowStockCount = Product::where('user_id', $user->id)->lowStock()->count();
        $lowStockProducts = Product::where('user_id', $user->id)->lowStock()->with('category')->latest()->take(10)->get();
        $deadStockCount = Product::where('user_id', $user->id)->deadStock()->count();
        $deadStockProducts = Product::where('user_id', $user->id)->deadStock()->with('category')->latest()->take(10)->get();

        return view('seller.dashboard', compact(
            'products',
            'orders',
            'totalProducts',
            'totalSales',
            'lowStockCount',
            'lowStockProducts',
            'deadStockCount',
            'deadStockProducts'
        ));
    }

    /**
     * Show seller products
     */
    public function products(): View
    {
        $products = Product::where('user_id', Auth::id())->with('category')->latest()->simplePaginate(15);
        return view('seller.products.index', compact('products'));
    }

    /**
     * Show create product form
     */
    public function createProduct(): View
    {
        $categories = Category::all();
        return view('seller.products.create', compact('categories'));
    }

    /**
     * Store new product
     */
    public function storeProduct(Request $request): RedirectResponse
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
            'category_name' => ['required', 'string', 'max:255'],
            'user_id' => Auth::id(),
        ];
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image_path'] = $path;
        }
        
        Product::create($data);

        return redirect()->route('seller.products')->with('status', 'Product created successfully');
    }

    /**
     * Show edit product form
     */
    public function editProduct(Product $product): View
    {
        if ($product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        
        $categories = Category::all();
        return view('seller.products.edit', compact('product', 'categories'));
    }

    /**
     * Update product
     */
    public function updateProduct(Request $request, Product $product): RedirectResponse
    {
        if ($product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'category_name' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        // $data = collect($validated)->except('image')->toArray();            ursor ne hatvaya hai
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

        return redirect()->route('seller.products')->with('status', 'Product updated successfully');
    }

    /**
     * Delete product
     */
    public function deleteProduct(Product $product): RedirectResponse
    {
        if ($product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $product->delete();
        return redirect()->route('seller.products')->with('status', 'Product deleted successfully');
    }

    /**
     * Show seller orders
     */
    public function orders(): View
    {
        $orders = Order::whereHas('items.product', function($query) {
            $query->where('user_id', Auth::id());
        })->with(['items.product', 'user'])->latest()->simplePaginate(15);
        
        return view('seller.orders.index', compact('orders'));
    }

    /**
     * Show specific order
     */
    public function showOrder(Order $order): View
    {
        $order->load(['items.product' => function($query) {
            $query->where('user_id', Auth::id());
        }, 'user']);
        
        return view('seller.orders.show', compact('order'));
    }



    /**
     * Show create category form
     */
    public function createCategory(): View
    {
        return view('admin.categories.create');
    }

    /**
     * Store new category
     */
    public function storeCategory(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'parent_id' => ['nullable', 'exists:categories,id'],
            'is_active' => ['boolean'],
        ]);

        Category::create([
            'name' => $validated['name'],
            'parent_id' => $validated['parent_id'] ?? null,
            'is_active' => $validated['is_active'] ?? true,
        ]);
        return redirect()->route('seller.products.create')->with('status', 'Category created successfully! You can now select it when creating a product.');
    }






}
