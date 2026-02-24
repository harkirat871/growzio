@extends('admin.layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <x-breadcrumbs :items="['Catalog' => null]" />
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Categories</h1>
            <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Add New Category
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow overflow-hidden sm:rounded-lg border border-gray-200">
            @if($rootCategories->count() > 0)
                <ul class="divide-y divide-gray-200">
                    @include('admin.categories._tree', ['categories' => $rootCategories])
                </ul>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-500">No categories found.</p>
                    <a href="{{ route('admin.categories.create') }}" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                        Add your first category
                    </a>
                </div>
            @endif
        </div>
</div>

<script>
function toggleCategory(categoryId) {
    const childrenList = document.getElementById('children-' + categoryId);
    const icon = document.getElementById('icon-' + categoryId);
    
    if (childrenList) {
        if (childrenList.classList.contains('hidden')) {
            childrenList.classList.remove('hidden');
            if (icon) icon.textContent = '▼';
        } else {
            childrenList.classList.add('hidden');
            if (icon) icon.textContent = '▶';
        }
    }
}
</script>
@endsection
