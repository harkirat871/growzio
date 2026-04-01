@extends('admin.layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <x-breadcrumbs :items="['Products' => route('admin.products.index'), 'Delete Products' => null]" />

        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h1 class="text-2xl font-semibold text-gray-900">Delete Products</h1>
            <a href="{{ route('admin.products.index') }}" class="text-sm text-indigo-600 hover:text-indigo-500">← Back to Products</a>
        </div>

        @if (session('success'))
            <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-800">{{ session('error') }}</div>
        @endif

        <div class="space-y-6">
            {{-- Delete products by category --}}
            <details open class="bg-darkgrey overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <summary class="flex items-center justify-between cursor-pointer list-none px-6 py-4 bg-darkgrey hover:bg-lightgrey font-medium text-gray-900">
                    Delete by Category
                    <span class="text-gray-400">▼</span>
                </summary>

                <div class="p-6 border-t border-gray-200">
                    <p class="text-sm text-gray-600 mb-4">
                        Select one or more categories. This will permanently delete products that are assigned
                        directly to the selected categories. Products in subcategories are NOT deleted unless their
                        category is also selected.
                    </p>

                    <form
                        method="POST"
                        action="{{ route('admin.products.delete-products.by-category') }}"
                        class="space-y-4"
                        onsubmit="return confirm('Are you sure you want to permanently delete products from the selected categories?');"
                    >
                        @csrf

                        <div class="border border-gray-200 rounded-md bg-white">
                            <ul class="p-3" style="max-height: 420px; overflow: auto;">
                                @if($rootCategories->count() > 0)
                                    @include('admin.products._category-tree-checkboxes', ['categories' => $rootCategories])
                                @else
                                    <li class="text-sm text-gray-600 py-2">No categories found.</li>
                                @endif
                            </ul>
                        </div>

                        <div class="flex flex-wrap items-center gap-3">
                            <button
                                type="submit"
                                class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700"
                            >
                                Delete Selected Products
                            </button>
                         
                        </div>
                    </form>
                </div>
            </details>

            {{-- Delete all --}}
            <details class="bg-darkgrey overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <summary class="flex items-center justify-between cursor-pointer list-none px-6 py-4 bg-darkgrey hover:bg-lightgrey font-medium text-gray-900">
                    Delete All Products
                    <span class="text-gray-400">▼</span>
                </summary>

                <div class="p-6 border-t border-gray-200">
                    <p class="text-sm text-gray-600 mb-4">
                        This will permanently delete all products (and order items referencing them).
                        There is no undo. Current product count: <strong>{{ $productCount }}</strong>.
                    </p>

                    <form
                        method="POST"
                        action="{{ route('admin.products.delete-products.destroy-all') }}"
                        onsubmit="return confirm('Are you absolutely sure? This will permanently delete ALL products.');"
                    >
                        @csrf
                        @method('DELETE')
                        <button
                            type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                        >
                            Yes, delete all products
                        </button>
                    </form>
                </div>
            </details>
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
</div>
@endsection

