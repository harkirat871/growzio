<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class OrderAdminController extends Controller
{
    public function index(Request $request): View
    {
        $userColumns = ['id', 'name', 'email', 'contact_number', 'business_name'];
        if (Schema::hasColumn('users', 'station')) {
            $userColumns[] = 'station';
        }

        $query = Order::with(['user:' . implode(',', $userColumns)])->withCount('items')->latest();

        if ($request->filled('status') && $request->status === 'pending') {
            $query->whereIn('status', ['pending', 'paid']);
        } elseif ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->simplePaginate(20)->withQueryString();
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $userColumns = [
            'id',
            'name',
            'email',
            'contact_number',
            'business_name',
            'gst_number',
            'referred_by',
            'address_line_1',
            'address_line_2',
            'city',
            'state',
            'postal_code',
            'country',
        ];
        if (Schema::hasColumn('users', 'station')) {
            $userColumns[] = 'station';
        }

        $order->load([
            'items.product:id,name',
            'user:' . implode(',', $userColumns),
        ]);
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:pending,paid,shipped,completed,cancelled'],
        ]);
        $order->update(['status' => $validated['status']]);
        return Redirect::back()->with('success', 'Order status updated');
    }
}


