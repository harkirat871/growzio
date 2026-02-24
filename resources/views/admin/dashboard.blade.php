@extends('admin.layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <x-breadcrumbs :items="[]" />
    <h1 class="text-2xl font-semibold text-gray-900 mb-6">What needs attention</h1>

    {{-- Needs Attention: Orders + Low Stock + Dead Stock --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 mb-8">
        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="block bg-amber-50 border border-amber-200 rounded-lg p-4 hover:bg-amber-100 transition">
            <div class="flex items-center justify-between">
                <span class="text-sm font-medium text-amber-800">Orders to fulfill</span>
                <span class="text-2xl font-bold text-amber-900">{{ $pendingOrdersCount ?? 0 }}</span>
            </div>
            <p class="mt-1 text-xs text-amber-700">Pending & paid — view and ship</p>
        </a>
        <a href="{{ route('admin.products.index', ['low_stock' => 1]) }}" class="block bg-orange-50 border border-orange-200 rounded-lg p-4 hover:bg-orange-100 transition">
            <div class="flex items-center justify-between">
                <span class="text-sm font-medium text-orange-800">Low stock items</span>
                <span class="text-2xl font-bold text-orange-900">{{ $lowStockCount ?? 0 }}</span>
            </div>
            <p class="mt-1 text-xs text-orange-700">Stock ≤ threshold — restock soon</p>
        </a>
        <a href="{{ route('admin.products.index', ['dead_stock' => 1]) }}" class="block bg-slate-50 border border-slate-200 rounded-lg p-4 hover:bg-slate-100 transition">
            <div class="flex items-center justify-between">
                <span class="text-sm font-medium text-slate-800">Dead stock</span>
                <span class="text-2xl font-bold text-slate-900">{{ $deadStockCount ?? 0 }}</span>
            </div>
            <p class="mt-1 text-xs text-slate-700">Not sold in 45+ days</p>
        </a>
    </div>

    {{-- Today's metrics --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 mb-8">
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-sm text-gray-500">Today's orders</p>
            <p class="text-2xl font-semibold text-gray-900">{{ $todayOrderCount ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-sm text-gray-500">Today's revenue</p>
            <p class="text-2xl font-semibold text-gray-900">₹{{ number_format($todayRevenue ?? 0, 2) }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-sm text-gray-500">Total products</p>
            <p class="text-2xl font-semibold text-gray-900">{{ $productCount ?? 0 }}</p>
        </div>
    </div>

    {{-- Quick actions --}}
    <div class="flex flex-wrap gap-3 mb-8">
        <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">View all orders</a>
        <a href="{{ route('admin.products.create') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50">Add product</a>
        <a href="{{ route('admin.products.bulk-upload') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50">Bulk upload</a>
        <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50">Manage catalog</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Pending orders (actionable) --}}
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-medium text-gray-900">Orders to fulfill</h2>
                <a href="{{ route('admin.orders.index') }}" class="text-sm text-indigo-600 hover:text-indigo-500">View all</a>
            </div>
            <ul class="divide-y divide-gray-200">
                @forelse($pendingOrders ?? [] as $order)
                <li>
                    <a href="{{ route('admin.orders.show', $order) }}" class="block px-4 py-3 hover:bg-gray-50">
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-900">#{{ $order->id }}</span>
                            <span class="text-gray-500">{{ $order->guest_name ?? optional($order->user)->name }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-500 mt-1">
                            <span>{{ ucfirst($order->status) }}</span>
                            <span>₹{{ number_format($order->total, 2) }}</span>
                        </div>
                    </a>
                </li>
                @empty
                <li class="px-4 py-8 text-center text-gray-500">No pending orders</li>
                @endforelse
            </ul>
        </div>

        {{-- Recent products --}}
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-medium text-gray-900">Recent products</h2>
                <a href="{{ route('admin.products.index') }}" class="text-sm text-indigo-600 hover:text-indigo-500">View all</a>
            </div>
            <ul class="divide-y divide-gray-200">
                @forelse($recentProducts ?? [] as $product)
                <li>
                    <a href="{{ route('admin.products.edit', $product) }}" class="block px-4 py-3 hover:bg-gray-50">
                        <div class="flex justify-between">
                            <span class="font-medium text-indigo-600 truncate">{{ $product->name }}</span>
                            <span class="text-gray-600">₹{{ number_format($product->price, 2) }}</span>
                        </div>
                        <div class="text-sm text-gray-500 mt-1">
                            {{ $product->category?->name ?? 'Uncategorized' }} · Stock: {{ $product->stock }}
                        </div>
                    </a>
                </li>
                @empty
                <li class="px-4 py-8 text-center text-gray-500">No products yet</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
