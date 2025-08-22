<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Your Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($items->count())
                        <div class="space-y-4">
                            @foreach ($items as $item)
                                <div class="flex items-center justify-between border rounded-md p-4">
                                    <div>
                                        <div class="font-semibold">{{ $item['product']->name }}</div>
                                        <div class="text-sm text-gray-600">
                                            <form method="POST" action="{{ route('cart.update', $item['product']) }}" class="flex items-center gap-2">
                                                @csrf
                                                @method('PUT')
                                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="w-20 border rounded-md p-1">
                                                <button class="text-xs bg-gray-800 text-white px-2 py-1 rounded">Update</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <div class="font-semibold">$ {{ number_format($item['subtotal'], 2) }}</div>
                                        <form method="POST" action="{{ route('cart.remove', $item['product']) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600 hover:underline">Remove</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6 flex items-center justify-between">
                            <div class="text-xl font-bold">Total: $ {{ number_format($total, 2) }}</div>
                            <div class="flex items-center gap-2">
                                <form method="POST" action="{{ route('cart.clear') }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="inline-block bg-gray-200 text-gray-700 px-4 py-2 rounded-md">Clear Cart</button>
                                </form>
                                <a href="{{ route('checkout.form') }}" class="inline-block bg-indigo-600 text-white px-4 py-2 rounded-md">Checkout</a>
                            </div>
                        </div>
                    @else
                        <p>Your cart is empty.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


