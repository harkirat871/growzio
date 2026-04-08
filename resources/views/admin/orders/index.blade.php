@extends('admin.layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <x-breadcrumbs :items="['Orders' => null]" />
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Orders</h1>
            <p class="text-sm text-gray-600 mt-1">Sorted by latest first. Time shown in IST (India).</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.orders.index') }}" class="inline-flex px-3 py-1.5 text-sm rounded-full {{ !request('status') ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">All</a>
            <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="inline-flex px-3 py-1.5 text-sm rounded-full {{ request('status') === 'pending' ? 'bg-amber-100 text-amber-800' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">To fulfill</a>
            <a href="{{ route('admin.orders.index', ['status' => 'shipped']) }}" class="inline-flex px-3 py-1.5 text-sm rounded-full {{ request('status') === 'shipped' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">Shipped</a>
            <a href="{{ route('admin.orders.index', ['status' => 'completed']) }}" class="inline-flex px-3 py-1.5 text-sm rounded-full {{ request('status') === 'completed' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">Completed</a>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-4 sm:p-6 text-gray-900">
            @php
                $statusClasses = [
                    'completed' => 'bg-green-100 text-green-800',
                    'cancelled' => 'bg-red-100 text-red-800',
                    'shipped' => 'bg-blue-100 text-blue-800',
                    'paid' => 'bg-blue-100 text-blue-800',
                    'pending' => 'bg-amber-100 text-amber-800',
                ];
            @endphp

            {{-- Desktop table --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full text-left">
                    <thead>
                        <tr class="border-b">
                            <th class="p-3 text-xs font-medium text-gray-500 uppercase">ID</th>
                            <th class="p-3 text-xs font-medium text-gray-500 uppercase">Placed (IST)</th>
                            <th class="p-3 text-xs font-medium text-gray-500 uppercase">Customer</th>
                            <th class="p-3 text-xs font-medium text-gray-500 uppercase">Station</th>
                            <th class="p-3 text-xs font-medium text-gray-500 uppercase">Items</th>
                            <th class="p-3 text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="p-3 text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="p-3 text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3 font-medium">#{{ $order->id }}</td>
                                <td class="p-3 text-sm">{{ \Illuminate\Support\Carbon::parse($order->created_at)->setTimezone('Asia/Kolkata')->format('d M Y, h:i A') }}</td>
                                <td class="p-3">
                                    <div class="font-medium">{{ $order->guest_name ?? optional($order->user)->name ?? 'N/A' }}</div>
                                    <div class="text-xs text-gray-600">{{ $order->guest_phone ?? optional($order->user)->contact_number ?? 'No phone' }}</div>
                                </td>
                                <td class="p-3 text-sm">{{ $order->delivery_location ?? optional($order->user)->station ?? 'N/A' }}</td>
                                <td class="p-3">{{ $order->items_count }}</td>
                                <td class="p-3">₹{{ number_format($order->total, 2) }}</td>
                                <td class="p-3"><span class="px-2 py-0.5 text-xs rounded-full {{ $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-800' }}">{{ ucfirst($order->status) }}</span></td>
                                <td class="p-3"><a href="{{ route('admin.orders.show', $order) }}" class="text-indigo-600 hover:underline font-medium">View</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Mobile cards --}}
            <div class="md:hidden space-y-4">
                @foreach ($orders as $order)
                    <a href="{{ route('admin.orders.show', $order) }}" class="block p-4 border border-gray-200 rounded-xl hover:bg-gray-50">
                        <div class="flex justify-between items-start gap-3">
                            <div>
                                <p class="font-semibold text-gray-900">#{{ $order->id }}</p>
                                <p class="text-xs text-gray-600 mt-1">{{ \Illuminate\Support\Carbon::parse($order->created_at)->setTimezone('Asia/Kolkata')->format('d M Y, h:i A') }} IST</p>
                            </div>
                            <span class="px-2 py-0.5 text-xs rounded-full {{ $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-800' }}">{{ ucfirst($order->status) }}</span>
                        </div>
                        <div class="mt-3 text-sm">
                            <p class="font-medium text-gray-900">{{ $order->guest_name ?? optional($order->user)->name ?? 'N/A' }}</p>
                            <p class="text-gray-600">{{ $order->guest_phone ?? optional($order->user)->contact_number ?? 'No phone' }}</p>
                            <p class="text-gray-600">Station: {{ $order->delivery_location ?? optional($order->user)->station ?? 'N/A' }}</p>
                        </div>
                        <div class="flex justify-between text-sm text-gray-500 mt-2">
                            <span>{{ $order->items_count }} items</span>
                            <span class="font-medium text-gray-900">₹{{ number_format($order->total, 2) }}</span>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-4">{{ $orders->links() }}</div>
        </div>
    </div>
</div>
@endsection
