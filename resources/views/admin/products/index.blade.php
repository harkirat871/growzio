@extends('admin.layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <x-breadcrumbs :items="['Products' => null]" />

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Products</h1>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('admin.products.bulk-upload') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md hover:bg-gray-700">Bulk Upload</a>
                    <a href="{{ route('admin.products.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">New Product</a>
                    <a href="{{ route('admin.products.destroy-all.confirm') }}" class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 border border-red-700">Delete All</a>
                </div>
            </div>
            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            @if (session('import_errors') && count(session('import_errors')) > 0)
                @php
                    $importErrorsCount = (int) session('import_errors_count', 0);
                    $importErrorsShown = is_array(session('import_errors')) ? count(session('import_errors')) : 0;
                    $importErrorsRemaining = session('import_errors_remaining', []);
                @endphp
                <div class="mb-6 bg-amber-50 border border-amber-300 text-amber-800 px-4 py-3 rounded relative" role="alert">
                    <p class="font-medium">
                        Import row errors (showing first {{ $importErrorsShown }} of {{ $importErrorsCount }}):
                    </p>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach (session('import_errors') as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>

                    @if ($importErrorsCount > $importErrorsShown && ! empty($importErrorsRemaining))
                        <details class="mt-2">
                            <summary class="cursor-pointer font-medium">Show all ({{ $importErrorsCount }})</summary>
                            <ul class="mt-1 list-disc list-inside text-sm">
                                @foreach ($importErrorsRemaining as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </details>
                    @endif
                </div>
            @endif
            @if (session('general_fallback_report') && count(session('general_fallback_report')) > 0)
                <div class="mb-6 bg-blue-50 border border-blue-300 text-blue-800 px-4 py-3 rounded relative" role="alert">
                    <p class="font-medium">Products assigned to General category (missing categories):</p>
                    <p class="text-sm mt-1">The following products were imported with one or more category levels set to "General" because the specified category did not exist in the database.</p>
                    <ul class="mt-3 list-none text-sm space-y-2">
                        @foreach (session('general_fallback_report') as $productName => $levels)
                            <li class="flex flex-wrap items-baseline gap-2">
                                <span class="font-medium">{{ e($productName) }}</span>
                                <span class="text-blue-600">→ Category level(s) set to General: Level {{ implode(', Level ', $levels) }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="flex flex-wrap gap-2 mb-4">
                <a href="{{ route('admin.products.index') }}" class="inline-flex px-3 py-1.5 text-sm rounded-full {{ empty($lowStockOnly) && empty($deadStockOnly) ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">All</a>
                <a href="{{ route('admin.products.index', ['low_stock' => 1]) }}" class="inline-flex px-3 py-1.5 text-sm rounded-full {{ !empty($lowStockOnly) ? 'bg-amber-100 text-amber-800' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">Low stock</a>
                <a href="{{ route('admin.products.index', ['dead_stock' => 1]) }}" class="inline-flex px-3 py-1.5 text-sm rounded-full {{ !empty($deadStockOnly) ? 'bg-slate-100 text-slate-800' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">Dead stock</a>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-4 sm:p-6">
                    <form method="GET" action="{{ route('admin.products.index') }}" class="flex flex-wrap items-center gap-2">
                        @if(!empty($lowStockOnly))
                            <input type="hidden" name="low_stock" value="1">
                        @endif
                        @if(!empty($deadStockOnly))
                            <input type="hidden" name="dead_stock" value="1">
                        @endif
                        <label for="admin-product-search" class="sr-only">Search products</label>
                        <input type="search"
                               id="admin-product-search"
                               name="q"
                               value="{{ old('q', $searchQuery ?? '') }}"
                               placeholder="Search by name, part number, brand…"
                               class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 max-w-md w-full text-sm">
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-sm font-medium">
                            Search
                        </button>
                        @if(!empty($searchQuery) || !empty($lowStockOnly) || !empty($deadStockOnly))
                            <a href="{{ route('admin.products.index') }}" class="text-gray-600 hover:text-gray-900 text-sm">Clear</a>
                        @endif
                    </form>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(!empty($searchQuery))
                        <p class="text-sm text-gray-600 mb-4">Search results for <strong>{{ e($searchQuery) }}</strong></p>
                    @endif
                    @if(!empty($lowStockOnly))
                        <p class="text-sm text-amber-700 mb-4">Showing <strong>low stock only</strong> (stock ≤ {{ \App\Models\Product::LOW_STOCK_THRESHOLD }}).</p>
                    @endif
                    @if(!empty($deadStockOnly))
                        <p class="text-sm text-slate-700 mb-4">Showing <strong>dead stock only</strong> (not sold in {{ \App\Models\Product::DEAD_STOCK_DAYS }} days).</p>
                    @endif
                    @php
                        $adminNextUrl = $products->nextPageUrl();
                        $adminNextUrlRelative = $adminNextUrl ? parse_url($adminNextUrl, PHP_URL_PATH) . (parse_url($adminNextUrl, PHP_URL_QUERY) ? '?' . parse_url($adminNextUrl, PHP_URL_QUERY) : '') : '';
                    @endphp
                    <div id="admin-products-infinite" data-next-url="{{ $adminNextUrlRelative }}" data-has-more="{{ $products->hasMorePages() ? '1' : '0' }}" data-csrf="{{ csrf_token() }}">
                        {{-- Desktop table --}}
                        <div class="hidden md:block overflow-x-auto">
                            <table class="min-w-full text-left">
                                <thead>
                                    <tr class="border-b">
                                        <th class="p-3 text-xs font-medium text-gray-500 uppercase">Name</th>
                                        <th class="p-3 text-xs font-medium text-gray-500 uppercase">Price</th>
                                        <th class="p-3 text-xs font-medium text-gray-500 uppercase">Stock</th>
                                        <th class="p-3 text-xs font-medium text-gray-500 uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="admin-products-tbody">
                                    @foreach ($products as $product)
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="p-3 font-medium">{{ $product->name }}</td>
                                            <td class="p-3">₹{{ number_format($product->price, 2) }}</td>
                                            <td class="p-3">{{ $product->stock }}</td>
                                            <td class="p-3 space-x-2">
                                                <a href="{{ route('admin.products.edit', $product) }}" class="text-indigo-600 hover:underline">Edit</a>
                                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- Mobile cards --}}
                        <div class="md:hidden space-y-4" id="admin-products-cards">
                            @foreach ($products as $product)
                                <div class="p-4 border border-gray-200 rounded-lg">
                                    <div class="flex justify-between items-start gap-2">
                                        <div class="min-w-0 flex-1">
                                            <a href="{{ route('admin.products.edit', $product) }}" class="font-medium text-indigo-600 truncate block">{{ $product->name }}</a>
                                            <div class="flex gap-3 text-sm text-gray-500 mt-1">
                                                <span>₹{{ number_format($product->price, 2) }}</span>
                                                <span>Stock: {{ $product->stock }}</span>
                                            </div>
                                        </div>
                                        <div class="flex gap-2 shrink-0">
                                            <a href="{{ route('admin.products.edit', $product) }}" class="text-indigo-600 hover:underline text-sm font-medium">Edit</a>
                                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline" onsubmit="return confirm('Delete this product?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline text-sm">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div id="admin-products-sentinel" aria-hidden="true" style="height:1px;visibility:hidden;"></div>
                        <div id="admin-products-loading" class="mt-4 text-center text-gray-500 text-sm hidden">Loading more...</div>
                        <div id="admin-products-end" class="mt-4 text-center text-gray-500 text-sm hidden">No more products.</div>
                        <div id="admin-products-error" class="mt-4 text-center text-red-600 text-sm hidden">Failed to load more. <button type="button" id="admin-products-retry" class="underline">Retry</button></div>
                    </div>
                </div>
            </div>
        </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var container = document.getElementById('admin-products-infinite');
        if (!container) return;
        var tbody = document.getElementById('admin-products-tbody');
        var cardsEl = document.getElementById('admin-products-cards');
        var sentinel = document.getElementById('admin-products-sentinel');
        var loadingEl = document.getElementById('admin-products-loading');
        var endEl = document.getElementById('admin-products-end');
        var errorEl = document.getElementById('admin-products-error');
        var retryBtn = document.getElementById('admin-products-retry');
        var loading = false;
        var nextUrl = container.getAttribute('data-next-url') || '';
        var hasMore = container.getAttribute('data-has-more') === '1';
        var csrf = container.getAttribute('data-csrf') || '';

        function buildRow(p) {
            return '<tr class="border-b hover:bg-gray-50">' +
                '<td class="p-3 font-medium">' + p.name + '</td>' +
                '<td class="p-3">' + p.price + '</td>' +
                '<td class="p-3">' + p.stock + '</td>' +
                '<td class="p-3 space-x-2">' +
                '<a href="' + p.edit_url + '" class="text-indigo-600 hover:underline">Edit</a>' +
                '<form method="POST" action="' + p.destroy_url + '" class="inline"><input type="hidden" name="_token" value="' + csrf + '"><input type="hidden" name="_method" value="DELETE"><button type="submit" class="text-red-600 hover:underline">Delete</button></form></td></tr>';
        }
        function buildCard(p) {
            return '<div class="p-4 border border-gray-200 rounded-lg">' +
                '<div class="flex justify-between items-start gap-2">' +
                '<div class="min-w-0 flex-1">' +
                '<a href="' + p.edit_url + '" class="font-medium text-indigo-600 truncate block">' + p.name + '</a>' +
                '<div class="flex gap-3 text-sm text-gray-500 mt-1"><span>' + p.price + '</span><span>Stock: ' + p.stock + '</span></div></div>' +
                '<div class="flex gap-2 shrink-0">' +
                '<a href="' + p.edit_url + '" class="text-indigo-600 hover:underline text-sm font-medium">Edit</a>' +
                '<form method="POST" action="' + p.destroy_url + '" class="inline" onsubmit="return confirm(\'Delete this product?\')">' +
                '<input type="hidden" name="_token" value="' + csrf + '"><input type="hidden" name="_method" value="DELETE">' +
                '<button type="submit" class="text-red-600 hover:underline text-sm">Delete</button></form></div></div></div>';
        }

        function fetchNext() {
            if (loading || !hasMore || !nextUrl) return;
            loading = true;
            errorEl.classList.add('hidden');
            loadingEl.classList.remove('hidden');
            var req = new XMLHttpRequest();
            req.open('GET', nextUrl, true);
            req.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            req.setRequestHeader('Accept', 'application/json');
            req.onload = function() {
                loading = false;
                loadingEl.classList.add('hidden');
                if (req.status >= 200 && req.status < 300) {
                    try {
                        var json = JSON.parse(req.responseText);
                        if (json.data && json.data.length) {
                            json.data.forEach(function(p) {
                                tbody.insertAdjacentHTML('beforeend', buildRow(p));
                                if (cardsEl) cardsEl.insertAdjacentHTML('beforeend', buildCard(p));
                            });
                        }
                        nextUrl = json.next_page_url || '';
                        hasMore = !!json.has_more_pages;
                        container.setAttribute('data-next-url', nextUrl);
                        container.setAttribute('data-has-more', hasMore ? '1' : '0');
                        if (!hasMore) endEl.classList.remove('hidden');
                    } catch (e) {
                        errorEl.classList.remove('hidden');
                    }
                } else {
                    errorEl.classList.remove('hidden');
                }
            };
            req.onerror = function() {
                loading = false;
                loadingEl.classList.add('hidden');
                errorEl.classList.remove('hidden');
            };
            req.send();
        }

        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) fetchNext();
            });
        }, { root: null, rootMargin: '200px 0px', threshold: 0 });
        if (sentinel) observer.observe(sentinel);
        if (!hasMore && !nextUrl) endEl.classList.remove('hidden');
        if (retryBtn) retryBtn.addEventListener('click', function() {
            errorEl.classList.add('hidden');
            fetchNext();
        });
    });
    </script>
</div>
@endsection


