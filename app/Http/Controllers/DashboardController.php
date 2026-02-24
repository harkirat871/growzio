<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = auth()->user();
        
        if ($user && $user->is_admin) {
            return $this->adminDashboard();
        }
        
        return $this->userDashboard();
    }
    
    private function adminDashboard(): View
    {
        $userId = auth()->id();
        $stats = [
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_users' => User::count(),
            'total_revenue' => Order::where('status', 'completed')->sum('total'),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'my_products' => Product::where('user_id', $userId)->count(),
        ];
        
        $recent_orders = Order::with('items.product')->latest()->take(5)->get();
        $recent_products = Product::latest()->take(5)->get();
        $my_products = Product::where('user_id', $userId)->latest()->take(5)->get();
        
        return view('dashboard.admin', compact('stats', 'recent_orders', 'recent_products', 'my_products'));
    }
    
    private function userDashboard(): View
    {
        $user = auth()->user();
        $userId = $user ? $user->id : null;
        
        $my_orders = Order::where('user_id', $userId)->with('items.product')->latest()->take(5)->get();
        $my_products = Product::where('user_id', $userId)->latest()->take(5)->get();
        
        $stats = [
            'total_orders' => Order::where('user_id', $userId)->count(),
            'total_products' => Product::where('user_id', $userId)->count(),
            'total_spent' => Order::where('user_id', $userId)->where('status', 'Delivered')->sum('total'),
            'loyalty_points' => $user ? (int) $user->loyalty_points : 0,
        ];

        return view('dashboard.user', compact('my_orders', 'my_products', 'stats'));
    }
}
