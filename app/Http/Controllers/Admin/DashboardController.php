<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Order;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(): View
    {
        $productCount = Product::count();
        $categoryCount = Category::count();
        $userCount = User::count();
        $orderCount = Order::count();
        $recentProducts = Product::latest()->take(5)->get();
        $recentCategories = Category::withCount('products')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'productCount',
            'categoryCount',
            'userCount',
            'orderCount',
            'recentProducts',
            'recentCategories'
        ));
    }
}
