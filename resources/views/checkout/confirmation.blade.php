<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order Confirmation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($order)
                        <p class="mb-4">Thank you! Your order #{{ $order->id }} has been placed.</p>
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
                    @else
                        <p>No recent order found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


