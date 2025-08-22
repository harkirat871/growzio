<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product') }}: {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-4">
                    @if ($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-64 h-64 object-cover rounded">
                    @endif
                    <div><span class="font-semibold">Name:</span> {{ $product->name }}</div>
                    <div><span class="font-semibold">Price:</span> $ {{ number_format($product->price, 2) }}</div>
                    <div><span class="font-semibold">Stock:</span> {{ $product->stock }}</div>
                    <div><span class="font-semibold">Description:</span> {{ $product->description }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


