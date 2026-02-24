@extends('admin.layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <x-breadcrumbs :items="['Products' => route('admin.products.index'), 'Edit' => null]" />

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <form method="POST" action="{{ route('admin.products.update', $product) }}" class="space-y-6" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Section: Basic info --}}
                <details open class="group border border-gray-200 rounded-lg">
                    <summary class="flex items-center justify-between cursor-pointer list-none px-4 py-3 bg-gray-50 rounded-t-lg hover:bg-gray-100">
                        <span class="font-medium text-gray-900">Basic info</span>
                        <span class="text-gray-400 group-open:rotate-180 transition-transform">▼</span>
                    </summary>
                    <div class="p-4 space-y-4 border-t border-gray-200">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Product Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('name', $product->name) }}" required>
                            @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Product Name (Hindi)</label>
                            <input type="text" name="product_name_hi" class="mt-1 block w-full border border-gray-300 rounded-md p-2" value="{{ old('product_name_hi', $product->product_name_hi) }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Brand Name</label>
                            <input type="text" name="brand_name" class="mt-1 block w-full border border-gray-300 rounded-md p-2" value="{{ old('brand_name', $product->brand_name) }}">
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">MRP (Price)</label>
                                <input type="number" name="price" step="0.01" class="mt-1 block w-full border border-gray-300 rounded-md p-2" value="{{ old('price', $product->price) }}">
                                @error('price')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Stock</label>
                                <input type="number" name="stock" min="0" class="mt-1 block w-full border border-gray-300 rounded-md p-2" value="{{ old('stock', $product->stock) }}">
                                @error('stock')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                </details>

                {{-- Section: Identifiers --}}
                <details class="group border border-gray-200 rounded-lg">
                    <summary class="flex items-center justify-between cursor-pointer list-none px-4 py-3 bg-gray-50 rounded-t-lg hover:bg-gray-100">
                        <span class="font-medium text-gray-900">Identifiers & part numbers</span>
                        <span class="text-gray-400 group-open:rotate-180 transition-transform">▼</span>
                    </summary>
                    <div class="p-4 space-y-4 border-t border-gray-200">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Company Part Number <span class="text-red-500">*</span></label>
                            <input type="text" name="company_part_number" class="mt-1 block w-full border border-gray-300 rounded-md p-2" value="{{ old('company_part_number', $product->company_part_number) }}" required>
                            @error('company_part_number')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Local Part Number</label>
                            <input type="text" name="local_part_number" class="mt-1 block w-full border border-gray-300 rounded-md p-2" value="{{ old('local_part_number', $product->local_part_number) }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Company Part Number Substitute</label>
                            <input type="text" name="company_part_number_substitute" class="mt-1 block w-full border border-gray-300 rounded-md p-2" value="{{ old('company_part_number_substitute', $product->company_part_number_substitute) }}">
                        </div>
                    </div>
                </details>

                {{-- Section: Categories --}}
                <details class="group border border-gray-200 rounded-lg">
                    <summary class="flex items-center justify-between cursor-pointer list-none px-4 py-3 bg-gray-50 rounded-t-lg hover:bg-gray-100">
                        <span class="font-medium text-gray-900">Categories</span>
                        <span class="text-gray-400 group-open:rotate-180 transition-transform">▼</span>
                    </summary>
                    <div class="p-4 space-y-4 border-t border-gray-200">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Category <span class="text-red-500">*</span></label>
                            <input type="text" name="category" value="{{ old('category', optional($product->category)->name) }}" class="mt-1 block w-full border border-gray-300 rounded-md p-2" required>
                            @error('category')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Category 2 (optional)</label>
                                <input type="text" name="category_2" value="{{ old('category_2', optional($product->category2)->name) }}" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                                @error('category_2')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Category 3 (optional)</label>
                                <input type="text" name="category_3" value="{{ old('category_3', optional($product->category3)->name) }}" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                                @error('category_3')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Category 4 (optional)</label>
                            <input type="text" name="category_4" value="{{ old('category_4', optional($product->category4)->name) }}" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                            @error('category_4')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </details>

                {{-- Section: Pricing & units --}}
                <details class="group border border-gray-200 rounded-lg">
                    <summary class="flex items-center justify-between cursor-pointer list-none px-4 py-3 bg-gray-50 rounded-t-lg hover:bg-gray-100">
                        <span class="font-medium text-gray-900">Pricing & units</span>
                        <span class="text-gray-400 group-open:rotate-180 transition-transform">▼</span>
                    </summary>
                    <div class="p-4 space-y-4 border-t border-gray-200">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">DLP</label>
                                <input type="number" name="dlp" step="0.01" class="mt-1 block w-full border border-gray-300 rounded-md p-2" value="{{ old('dlp', $product->dlp) }}">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Unit</label>
                                <input type="text" name="unit" class="mt-1 block w-full border border-gray-300 rounded-md p-2" value="{{ old('unit', $product->unit) }}">
                            </div>
                        </div>
                    </div>
                </details>

                {{-- Section: Media --}}
                <details class="group border border-gray-200 rounded-lg">
                    <summary class="flex items-center justify-between cursor-pointer list-none px-4 py-3 bg-gray-50 rounded-t-lg hover:bg-gray-100">
                        <span class="font-medium text-gray-900">Image</span>
                        <span class="text-gray-400 group-open:rotate-180 transition-transform">▼</span>
                    </summary>
                    <div class="p-4 border-t border-gray-200">
                        <input type="file" name="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" accept="image/*">
                        @if ($product->image_path)
                            <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" class="w-32 h-32 object-cover rounded mt-4">
                        @endif
                    </div>
                </details>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 font-medium">Save changes</button>
                    <a href="{{ route('admin.products.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
