@extends('admin.layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-2 border-red-200">
                <div class="p-6">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h1 class="text-xl font-semibold text-gray-900 mb-2">This action is irreversible</h1>
                            <p class="text-gray-700 mb-4">
                                You are about to <strong>permanently delete all {{ $productCount }} product(s)</strong> in the database.
                            </p>
                            <ul class="list-disc list-inside text-gray-600 text-sm space-y-1 mb-6">
                                <li>All products will be removed, including those in any category.</li>
                                <li>Order line items that reference products will also be deleted (order history will show orders without product details).</li>
                                <li>Product images on disk are not removed; you may clean those manually if needed.</li>
                                <li>This cannot be undone. There is no backup or restore.</li>
                            </ul>
                            <div class="flex flex-wrap items-center gap-3">
                                <form method="POST" action="{{ route('admin.products.destroy-all') }}" class="inline" onsubmit="return confirm('Are you absolutely sure? This will permanently delete ALL {{ $productCount }} product(s).');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        Yes, delete all products
                                    </button>
                                </form>
                                <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection
