@extends('admin.layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <x-breadcrumbs :items="['Orders' => route('admin.orders.index'), 'Order #' . $order->id => null]" />
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-6">
                    <div>
                        <div class="font-semibold">Customer</div>
                        <div>{{ $order->guest_name ?? optional($order->user)->name }} ({{ $order->guest_email ?? optional($order->user)->email }})</div>
                        <div>{{ $order->guest_address }}</div>
                    </div>

                    <div>
                        <div class="font-semibold mb-2">Items</div>
                        <div class="space-y-2">
                            @foreach ($order->items as $item)
                                <div class="flex items-center justify-between">
                                    <div>{{ $item->product->name }} (x{{ $item->quantity }})</div>
                                    <div>₹{{ number_format($item->subtotal, 2) }}</div>
                                </div>
                            @endforeach
                            <div class="flex items-center justify-between font-bold border-t pt-2">
                                <div>Total</div>
                                <div>₹{{ number_format($order->total, 2) }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <div class="text-sm font-semibold text-gray-700 mb-3">Update status</div>
                        <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="flex flex-col sm:flex-row sm:items-center gap-4">
                            @csrf
                            @method('PUT')
                            <label for="order-status" class="text-sm font-medium text-gray-700 shrink-0">Status</label>
                            <select name="status" id="order-status"
                                class="block w-full sm:w-48 min-h-[2.75rem] px-4 py-2.5 text-base text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 focus:outline-none transition appearance-none cursor-pointer"
                                style="background-image: url('data:image/svg+xml;charset=utf-8,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 fill=%22none%22 viewBox=%220 0 24 24%22 stroke=%22%236b7280%22%3E%3Cpath stroke-linecap=%22round%22 stroke-linejoin=%22round%22 stroke-width=%222%22 d=%22M19 9l-7 7-7-7%22/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1.25rem; padding-right: 2.5rem;">
                                @foreach (['pending','paid','shipped','completed','cancelled'] as $s)
                                    <option value="{{ $s }}" @selected($order->status === $s)>{{ ucfirst($s) }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg hover:bg-indigo-700 font-medium text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 shrink-0">Update status</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection


