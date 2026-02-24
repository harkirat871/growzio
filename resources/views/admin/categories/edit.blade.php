@extends('admin.layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <x-breadcrumbs :items="['Catalog' => route('admin.categories.index'), 'Edit ' . $category->name => null]" />
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Edit Category</h1>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="p-6" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="parent_id" class="block text-sm font-medium text-gray-700">Parent Category</label>
                    <select name="parent_id" id="parent_id" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">None (root category)</option>
                        @foreach($parentOptions as $opt)
                            <option value="{{ $opt->id }}" {{ old('parent_id', $category->parent_id) == $opt->id ? 'selected' : '' }}>
                                {{ $opt->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Category Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700">Category Image (optional)</label>
                    @if($category->image_path)
                        <div class="mt-1 mb-2">
                            <img src="{{ asset($category->image_path) }}" alt="{{ $category->name }}" class="h-24 w-24 object-contain rounded border border-gray-200">
                            <p class="text-sm text-gray-500 mt-1">Current image. Upload a new one to replace.</p>
                        </div>
                    @endif
                    <input type="file" name="image" id="image" accept="image/*"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <p class="mt-1 text-sm text-gray-500">Shows in Shop by Category and on category page. Max 2MB.</p>
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end space-x-3">
                    <a href="{{ route('admin.categories.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                        Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection