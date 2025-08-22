<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.products.update', $product) }}" class="space-y-4" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name" class="mt-1 block w-full border rounded-md p-2" value="{{ old('name', $product->name) }}" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" class="mt-1 block w-full border rounded-md p-2" rows="4" required>{{ old('description', $product->description) }}</textarea>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Price</label>
                                <input type="number" name="price" step="0.01" class="mt-1 block w-full border rounded-md p-2" value="{{ old('price', $product->price) }}" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Stock</label>
                                <input type="number" name="stock" class="mt-1 block w-full border rounded-md p-2" value="{{ old('stock', $product->stock) }}" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Image</label>
                                <input type="file" name="image" class="mt-1 block w-full border rounded-md p-2" accept="image/*">
                                @if ($product->image_path)
                                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-32 h-32 object-cover rounded mt-2">
                                @endif
                            </div>
                        </div>
                        <button class="bg-indigo-600 text-white px-4 py-2 rounded-md">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


