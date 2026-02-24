<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard (decision-focused for single-vendor).
     */
    public function index(): View
    {
        $todayOrders = Order::whereDate('created_at', today())->get();
        $todayRevenue = $todayOrders->sum('total');
        $pendingOrders = Order::whereIn('status', ['pending', 'paid'])->latest()->take(5)->get();
        $pendingOrdersCount = Order::whereIn('status', ['pending', 'paid'])->count();
        $recentOrders = Order::withCount('items')->latest()->take(5)->get();

        $productCount = Product::count();
        $categoryCount = Category::count();
        $orderCount = Order::count();
        $recentProducts = Product::with('category')->latest()->take(5)->get();
        $lowStockCount = Product::lowStock()->count();
        $deadStockCount = Product::deadStock()->count();

        $todayOrderCount = $todayOrders->count();

        return view('admin.dashboard', compact(
            'todayOrders',
            'todayRevenue',
            'todayOrderCount',
            'pendingOrders',
            'pendingOrdersCount',
            'recentOrders',
            'productCount',
            'categoryCount',
            'orderCount',
            'recentProducts',
            'lowStockCount',
            'deadStockCount'
        ));
    }
}
