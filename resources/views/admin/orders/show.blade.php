<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order #') }}{{ $order->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
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
                                    <div>$ {{ number_format($item->subtotal, 2) }}</div>
                                </div>
                            @endforeach
                            <div class="flex items-center justify-between font-bold border-t pt-2">
                                <div>Total</div>
                                <div>$ {{ number_format($order->total, 2) }}</div>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('orders.update', $order) }}" class="flex items-center gap-2">
                        @csrf
                        @method('PUT')
                        <select name="status" class="border rounded-md p-2">
                            @foreach (['pending','paid','shipped','completed','cancelled'] as $s)
                                <option value="{{ $s }}" @selected($order->status === $s)>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                        <button class="bg-indigo-600 text-white px-4 py-2 rounded-md">Update Status</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


