<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($items->count())
                        <form method="POST" action="{{ route('checkout.store') }}" class="space-y-6">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Name</label>
                                    <input type="text" name="guest_name" class="mt-1 block w-full border rounded-md p-2" value="{{ old('guest_name') }}" required>
                                    @error('guest_name')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" name="guest_email" class="mt-1 block w-full border rounded-md p-2" value="{{ old('guest_email') }}" required>
                                    @error('guest_email')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Phone</label>
                                    <input type="text" name="guest_phone" class="mt-1 block w-full border rounded-md p-2" value="{{ old('guest_phone') }}">
                                    @error('guest_phone')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Address</label>
                                    <textarea name="guest_address" class="mt-1 block w-full border rounded-md p-2" rows="3" required>{{ old('guest_address') }}</textarea>
                                    @error('guest_address')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Delivery Location</label>
                                    <input type="text" name="delivery_location" class="mt-1 block w-full border rounded-md p-2" value="{{ old('delivery_location') }}">
                                    @error('delivery_location')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div class="border-t pt-4">
                                <h3 class="font-semibold mb-2">Order Summary</h3>
                                <div class="space-y-2">
                                    @foreach ($items as $item)
                                        <div class="flex items-center justify-between">
                                            <div>{{ $item['product']->name }} (x{{ $item['quantity'] }})</div>
                                            <div>$ {{ number_format($item['subtotal'], 2) }}</div>
                                        </div>
                                    @endforeach
                                    <div class="flex items-center justify-between font-bold border-t pt-2">
                                        <div>Total</div>
                                        <div>$ {{ number_format($total, 2) }}</div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md">Place Order</button>
                        </form>
                    @else
                        <p>Your cart is empty.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


