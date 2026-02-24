<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order Details') }}
        </h2>
    </x-slot>
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Order #{{ $order->id }}</h1>
            <a href="{{ route('seller.orders') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Orders
            </a>
        </div>

        <!-- Update Order Status -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Update Order Status</h3>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                <form method="POST" action="{{ route('seller.orders.updateStatus', $order) }}" class="flex items-center gap-2">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="border rounded-md p-2">
                        @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                            <option value="{{ $s }}" @selected($order->status === $s)>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">Update</button>
                </form>
                @if(session('status'))
                    <div class="mt-2 text-green-600">{{ session('status') }}</div>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Order Details -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Order Information</h3>
                    </div>
                    <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <p class="text-sm text-gray-600"><span class="font-medium">Order ID:</span> #{{ $order->id }}</p>
                                <p class="text-sm text-gray-600"><span class="font-medium">Order Date:</span> {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
                                <p class="text-sm text-gray-600"><span class="font-medium">Status:</span> 
                                    @if($order->status === 'pending')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                                    @elseif($order->status === 'processing')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Processing</span>
                                    @elseif($order->status === 'shipped')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">Shipped</span>
                                    @elseif($order->status === 'delivered')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Delivered</span>
                                    @elseif($order->status === 'cancelled')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Cancelled</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ ucfirst($order->status) }}</span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600"><span class="font-medium">Total Amount:</span> <span class="text-green-600 font-semibold">₹{{ number_format($order->total, 2) }}</span></p>
                                @if($order->delivery_location)
                                    <p class="text-sm text-gray-600"><span class="font-medium">Delivery Location:</span> {{ $order->delivery_location }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Customer Information</h3>
                    </div>
                    <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                        <p class="text-sm text-gray-600"><span class="font-medium">Name:</span> {{ $order->user->name }}</p>
                        <p class="text-sm text-gray-600"><span class="font-medium">Email:</span> {{ $order->user->email }}</p>
                        @if($order->user->phone)
                            <p class="text-sm text-gray-600"><span class="font-medium">Phone:</span> {{ $order->user->phone }}</p>
                        @endif
                    </div>
                </div>

                <!-- Order Items -->
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Order Items (Your Products)</h3>
                    </div>
                    <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                        @php
                            $sellerItems = $order->items->filter(function($item) {
                                return $item->product && $item->product->user_id == auth()->id();
                            });
                        @endphp

                        @if($sellerItems->count() > 0)
                            @foreach($sellerItems as $item)
                                <div class="flex items-center border-b border-gray-200 pb-4 mb-4 last:border-b-0 last:pb-0 last:mb-0">
                                    <div class="flex-shrink-0 mr-4">
                                        @if($item->product->image_path)
                                            <img src="{{ asset($item->product->image_path) }}" 
                                                 alt="{{ $item->product->name }}" 
                                                 class="h-20 w-20 rounded-lg object-cover">
                                        @else
                                            <div class="h-20 w-20 rounded-lg bg-gray-200 flex items-center justify-center">
                                                <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium text-gray-900 mb-1">{{ $item->product->name }}</h4>
                                        <p class="text-sm text-gray-500 mb-2">{{ Str::limit($item->product->description, 100) }}</p>
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-500">Quantity: {{ $item->quantity }}</span>
                                            <span class="text-sm font-semibold text-gray-900">₹{{ number_format($item->price, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-gray-500 text-center">No items from your products in this order.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="space-y-6">
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Order Summary</h3>
                    </div>
                    <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                        @php
                            $sellerTotal = $sellerItems->sum(function($item) {
                                return $item->price * $item->quantity;
                            });
                        @endphp
                        
                        <div class="flex justify-between mb-2">
                            <span class="text-sm text-gray-600">Your Products Total:</span>
                            <span class="text-sm font-medium text-gray-900">₹{{ number_format($sellerTotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-sm text-gray-600">Order Total:</span>
                            <span class="text-sm font-medium text-gray-900">₹{{ number_format($order->total, 2) }}</span>
                        </div>
                        
                        <hr class="my-4">
                        
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Your Commission:</span>
                            <span class="text-sm font-semibold text-green-600">₹{{ number_format($sellerTotal, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                    
                   
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
