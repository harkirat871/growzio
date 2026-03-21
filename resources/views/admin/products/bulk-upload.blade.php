@extends('admin.layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <x-breadcrumbs :items="['Products' => route('admin.products.index'), 'Bulk Upload' => null]" />
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h1 class="text-2xl font-semibold text-gray-900">Bulk Upload</h1>
            <a href="{{ route('admin.products.index') }}" class="text-sm text-indigo-600 hover:text-indigo-500">← Back to Products</a>
        </div>

        @if (session('success'))
            <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-800">{{ session('error') }}</div>
        @endif
        @if (session('import_errors_count') && session('import_errors_count') > 0)
            @php
                $importErrorsCount = (int) session('import_errors_count', 0);
                $importErrorsShown = is_array(session('import_errors')) ? count(session('import_errors')) : 0;
                $importErrorsRemaining = session('import_errors_remaining', []);
            @endphp
            <div class="mb-4 rounded-md bg-amber-50 p-4 text-sm text-amber-800">
                <strong>{{ $importErrorsCount }} row(s) had errors.</strong>
                @if (session('import_errors') && $importErrorsShown > 0)
                    <ul class="mt-2 list-inside list-disc text-amber-700">
                        @foreach (session('import_errors') as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                @endif

                @if ($importErrorsCount > $importErrorsShown && ! empty($importErrorsRemaining))
                    <details class="mt-2">
                        <summary class="cursor-pointer font-medium">Show all ({{ $importErrorsCount }})</summary>
                        <ul class="mt-1 list-inside list-disc text-amber-700">
                            @foreach ($importErrorsRemaining as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </details>
                @endif
            </div>
        @endif
        @if (session('zip_unmatched_count') && session('zip_unmatched_count') > 0)
            <div class="mb-4 rounded-md bg-amber-50 p-4 text-sm text-amber-800">
                <strong>{{ session('zip_unmatched_count') }} image(s) could not be matched</strong> to a product (by name or company part number).
                @if (session('zip_unmatched'))
                    <details class="mt-2">
                        <summary class="cursor-pointer font-medium">Unmatched filenames (first 50)</summary>
                        <ul class="mt-1 list-inside list-disc text-amber-700">
                            @foreach (session('zip_unmatched') as $name)
                                <li>{{ $name }}</li>
                            @endforeach
                        </ul>
                    </details>
                @endif
            </div>
        @endif

        <div class="space-y-6">
            {{-- Import new products --}}
            <details open class="bg-darkgrey overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <summary class="flex items-center justify-between cursor-pointer list-none px-6 py-4 bg-darkgrey hover:bg-lightgrey font-medium text-gray-900">
                    Import new products from CSV
                    <span class="text-gray-400">▼</span>
                </summary>
                <div class="p-6 border-t border-gray-200">
                    <p class="text-sm text-gray-600 mb-4">Upload a CSV to add new products. <a href="{{ route('admin.products.bulk-upload.template') }}" class="text-indigo-600 hover:text-indigo-500 font-medium">Download template</a></p>
                    <form method="POST" action="{{ route('admin.products.bulk-upload.process') }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label for="csv_file" class="block text-sm font-medium text-gray-700">CSV File</label>
                            <input type="file" name="csv_file" id="csv_file" accept=".csv,.txt" required class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            @error('csv_file')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">Upload & Import</button>
                    </form>
                </div>
            </details>

            {{-- Bulk update existing --}}
            <details class="bg-darkgrey overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <summary class="flex items-center justify-between cursor-pointer list-none px-6 py-4 bg-darkgrey hover:bg-lightgrey font-medium text-gray-900">
                    Update existing products
                    <span class="text-gray-400">▼</span>
                </summary>
                <div class="p-6 border-t border-gray-200">
                    <p class="text-sm text-gray-600 mb-4">Match by <strong>id</strong> or <strong>company_part_number</strong>. Empty cells leave data unchanged. <a href="{{ route('admin.products.bulk-update.template') }}" class="text-indigo-600 hover:text-indigo-500 font-medium">Download template</a></p>
                    <form method="POST" action="{{ route('admin.products.bulk-update.process') }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label for="csv_file_update" class="block text-sm font-medium text-gray-700">CSV File</label>
                            <input type="file" name="csv_file" id="csv_file_update" accept=".csv,.txt" required class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            @error('csv_file')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-700 text-white text-sm font-medium rounded-md hover:bg-gray-800">Upload & Update</button>
                    </form>
                </div>
            </details>

            {{-- ZIP images --}}
            <details class="bg-darkgrey overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <summary class="flex items-center justify-between cursor-pointer list-none px-6 py-4 bg-darkgrey hover:bg-lightgrey font-medium text-gray-900">
                    Assign images from ZIP
                    <span class="text-gray-400">▼</span>
                </summary>
                <div class="p-6 border-t border-gray-200">
                    <p class="text-sm text-gray-600 mb-4">Match filenames to product name or company_part_number. Max 100MB. JPG, PNG, GIF, WebP.</p>
                    <form method="POST" action="{{ route('admin.products.bulk-upload.zip-images') }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label for="zip_file" class="block text-sm font-medium text-gray-700">ZIP File</label>
                            <input type="file" name="zip_file" id="zip_file" accept=".zip" required class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            @error('zip_file')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">Upload ZIP & Assign</button>
                    </form>
                </div>
            </details>
        </div>

        {{-- Help: CSV format --}}
        <details class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
            <summary class="flex items-center justify-between cursor-pointer list-none px-6 py-3 text-sm font-medium text-gray-600 hover:text-gray-900">
                CSV format & column reference
                <span class="text-gray-400">▼</span>
            </summary>
            <div class="p-6 border-t border-gray-200">
                <h2 class="text-base font-medium text-gray-900 mb-3">CSV Format & Column Flexibility</h2>
                <p class="text-sm text-gray-600 mb-4">
                    Your CSV must have a header row. Column names are matched <strong>case-insensitively</strong> and <strong>spaces, underscores, and dashes are ignored</strong> (e.g. <code>product name</code>, <code>product_name</code>, <code>product-name</code> all map to the same field).
                    <a href="{{ route('admin.products.bulk-upload.template') }}" class="text-indigo-600 hover:text-indigo-500 font-medium ml-1">Download template CSV</a>
                </p>

                <p class="text-sm font-medium text-gray-700 mb-2">Required columns (one of these names per field):</p>
                <ul class="text-sm text-gray-600 list-disc list-inside mb-4 space-y-1">
                    <li><strong>name</strong> — name, product_name, product name, product, title, item_name</li>
                    <li><strong>company_part_number</strong> — company_part_number, part_number, part number, part_no, sku, model, code</li>
                    <li><strong>category</strong> — category, category_name, product_category, type, group (must exist in Categories; not created automatically)</li>
                </ul>

                <p class="text-sm font-medium text-gray-700 mb-2">Optional columns (accepted names):</p>
                <ul class="text-sm text-gray-600 list-disc list-inside mb-2 space-y-1">
                    <li><strong>price</strong> — price, mrp, cost, amount, unit_price, selling_price (currency symbols stripped)</li>
                    <li><strong>stock</strong> — stock, quantity, inventory, qty, available_stock</li>
                    <li><strong>brand_name</strong> — brand_name, brand, manufacturer, vendor</li>
                    <li><strong>description</strong> — description, desc, details, product_description</li>
                    <li>product_name_hi, local_part_number, company_part_number_substitute, category_2, category_3, category_4, dlp, unit</li>
                </ul>

                <p class="text-sm text-gray-500 mt-4">Empty rows are skipped. Duplicate <code>company_part_number</code> rows are skipped. Encoding normalized to UTF-8.</p>
            </div>
        </details>

        {{-- Help: ZIP matching rules --}}
        <details class="mt-4 bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
            <summary class="flex items-center justify-between cursor-pointer list-none px-6 py-3 text-sm font-medium text-gray-600 hover:text-gray-900">
                ZIP image matching rules
                <span class="text-gray-400">▼</span>
            </summary>
            <div class="p-6 border-t border-gray-200">
                <h2 class="text-base font-medium text-gray-900 mb-3">ZIP Image Matching Rules</h2>
                <p class="text-sm text-gray-700 mb-2"><strong>Pass 1 — By product name:</strong> Filenames are normalized (lowercase, spaces/underscores/hyphens removed). Exact match or “contains” (filename contains product name or vice versa) links the image to that product. Examples:</p>
                <ul class="text-sm text-gray-600 list-disc list-inside mb-3 space-y-1">
                    <li><code>Apple iPhone 15 Pro Max.jpg</code>, <code>apple_iphone_15_pro_max.jpg</code>, <code>Apple-iPhone-15-Pro-Max.jpg</code></li>
                    <li><code>iphone_15_pro_max_black_256gb.jpg</code> (contains name)</li>
                    <li>With prefixes/suffixes: <code>IMG_Apple iPhone.jpg</code>, <code>Apple iPhone_001.jpg</code>, <code>Apple iPhone-main.jpg</code></li>
                </ul>
                <p class="text-sm text-gray-700 mb-2"><strong>Pass 2 — By company part number (remaining only):</strong> Same normalization and exact/contains logic. Examples:</p>
                <ul class="text-sm text-gray-600 list-disc list-inside mb-2 space-y-1">
                    <li><code>ABC-123.jpg</code>, <code>ABC123.jpg</code>, <code>IMG_ABC123.jpg</code>, <code>product_ABC-123_front_view.jpg</code>, <code>ABC-123 (1).jpg</code></li>
                </ul>
                <p class="text-sm text-gray-500">Name match first, then company_part_number. Unmatched filenames listed after upload.</p>
            </div>
        </details>
    </div>
</div>
@endsection
