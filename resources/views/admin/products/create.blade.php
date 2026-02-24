@extends('admin.layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <x-breadcrumbs :items="['Products' => route('admin.products.index'), 'Add product' => null]" />
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.products.store') }}" class="space-y-4" enctype="multipart/form-data">
                        @csrf

                        <!-- 1. Product Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Product Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="mt-1 block w-full border rounded-md p-2" required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- 2. Product Name (Hindi) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Product Name (Hindi)</label>
                            <input type="text" name="product_name_hi" value="{{ old('product_name_hi') }}" class="mt-1 block w-full border rounded-md p-2">
                        </div>

                        <!-- 3. Brand Name (nullable) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Brand Name</label>
                            <input type="text" name="brand_name" value="{{ old('brand_name') }}" class="mt-1 block w-full border rounded-md p-2">
                        </div>

                        <!-- 4. Local Part Number (nullable) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Local Part Number</label>
                            <input type="text" name="local_part_number" value="{{ old('local_part_number') }}" class="mt-1 block w-full border rounded-md p-2">
                        </div>

                        <!-- 5. Company Part Number (required) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Company Part Number</label>
                            <input type="text" name="company_part_number" value="{{ old('company_part_number') }}" class="mt-1 block w-full border rounded-md p-2" required>
                            @error('company_part_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- 6. Company Part Number Substitute (nullable) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Company Part Number Substitute</label>
                            <input type="text" name="company_part_number_substitute" value="{{ old('company_part_number_substitute') }}" class="mt-1 block w-full border rounded-md p-2">
                        </div>

                        <!-- 7. Category (required) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Category</label>
                            <input type="text" name="category" value="{{ old('category') }}" class="mt-1 block w-full border rounded-md p-2" required>
                            @error('category')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category 2 (optional) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Category 2 (optional)</label>
                            <input type="text" name="category_2" value="{{ old('category_2') }}" class="mt-1 block w-full border rounded-md p-2">
                            @error('category_2')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category 3 (optional) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Category 3 (optional)</label>
                            <input type="text" name="category_3" value="{{ old('category_3') }}" class="mt-1 block w-full border rounded-md p-2">
                            @error('category_3')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category 4 (optional) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Category 4 (optional)</label>
                            <input type="text" name="category_4" value="{{ old('category_4') }}" class="mt-1 block w-full border rounded-md p-2">
                            @error('category_4')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- 8. MRP (price) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">MRP</label>
                            <input type="number" name="price" step="0.01" value="{{ old('price') }}" class="mt-1 block w-full border rounded-md p-2">
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Stock -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Stock</label>
                            <input type="number" name="stock" min="0" value="{{ old('stock', 0) }}" class="mt-1 block w-full border rounded-md p-2">
                            @error('stock')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- 9. DLP (nullable) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">DLP</label>
                            <input type="number" name="dlp" step="0.01" value="{{ old('dlp') }}" class="mt-1 block w-full border rounded-md p-2">
                        </div>

                        <!-- 10. Unit (nullable) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Unit</label>
                            <input type="text" name="unit" value="{{ old('unit') }}" class="mt-1 block w-full border rounded-md p-2">
                        </div>

                        <!-- 11. Image upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Image</label>
                            <input type="file" name="image" class="mt-1 block w-full border rounded-md p-2" accept="image/*">
                        </div>

                        <button class="bg-indigo-600 text-white px-4 py-2 rounded-md">Create</button>
                    </form>
                </div>
            </div>
        </div>
@endsection
