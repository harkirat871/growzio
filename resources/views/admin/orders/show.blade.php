@extends('admin.layouts.app')

@section('content')
@php
    $istPlacedAt = \Illuminate\Support\Carbon::parse($order->created_at)->setTimezone('Asia/Kolkata');
    $customerName = $order->guest_name ?? optional($order->user)->name ?? 'N/A';
    $customerEmail = $order->guest_email ?? optional($order->user)->email ?? 'N/A';
    $customerPhone = $order->guest_phone ?? optional($order->user)->contact_number ?? 'N/A';
    $customerStation = $order->delivery_location ?? optional($order->user)->station ?? 'N/A';
    $businessName = optional($order->user)->business_name ?? 'N/A';
    $gstNumber = optional($order->user)->gst_number ?? 'N/A';
    $referredBy = optional($order->user)->referred_by ?? 'N/A';
    $address = $order->guest_address ?: (optional($order->user)->full_address ?: 'N/A');
    $statusClasses = [
        'completed' => 'bg-green-100 text-green-800',
        'cancelled' => 'bg-red-100 text-red-800',
        'shipped' => 'bg-blue-100 text-blue-800',
        'paid' => 'bg-blue-100 text-blue-800',
        'pending' => 'bg-amber-100 text-amber-800',
    ];
    $itemsSubtotal = (float) $order->items->sum('subtotal');
    $discountAmount = (float) ($order->loyalty_discount_amount ?? 0);
@endphp

<div class="max-w-6xl mx-auto">
    <x-breadcrumbs :items="['Orders' => route('admin.orders.index'), 'Order #' . $order->id => null]" />
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-4 sm:p-6 text-gray-900 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
                <div>
                    <h1 class="text-xl font-semibold">Order #{{ $order->id }}</h1>
                    <p class="text-sm text-gray-600 mt-1">Placed {{ $istPlacedAt->format('d M Y, h:i A') }} IST</p>
                </div>
                <span class="px-3 py-1 text-xs rounded-full w-fit {{ $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-800' }}">{{ ucfirst($order->status) }}</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <div class="rounded-xl border border-gray-200 p-4">
                    <h2 class="font-semibold mb-3">Customer details</h2>
                    <dl class="space-y-2 text-sm">
                        <div class="flex justify-between gap-3">
                            <dt class="text-gray-600">Party / Name</dt>
                            <dd class="text-right font-medium">{{ $customerName }}</dd>
                        </div>
                        <div class="flex justify-between gap-3">
                            <dt class="text-gray-600">Email</dt>
                            <dd class="text-right">{{ $customerEmail }}</dd>
                        </div>
                        <div class="flex justify-between gap-3">
                            <dt class="text-gray-600">Phone</dt>
                            <dd class="text-right">{{ $customerPhone }}</dd>
                        </div>
                        <div class="flex justify-between gap-3">
                            <dt class="text-gray-600">Station / Area</dt>
                            <dd class="text-right">{{ $customerStation }}</dd>
                        </div>
                        <div class="flex justify-between gap-3">
                            <dt class="text-gray-600">Business Name</dt>
                            <dd class="text-right">{{ $businessName }}</dd>
                        </div>
                        <div class="flex justify-between gap-3">
                            <dt class="text-gray-600">GST</dt>
                            <dd class="text-right">{{ $gstNumber }}</dd>
                        </div>
                        <div class="flex justify-between gap-3">
                            <dt class="text-gray-600">Referred By</dt>
                            <dd class="text-right">{{ $referredBy }}</dd>
                        </div>
                        <div class="pt-1 border-t border-gray-200">
                            <dt class="text-gray-600 mb-1">Address</dt>
                            <dd class="text-sm">{{ $address }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="rounded-xl border border-gray-200 p-4">
                    <h2 class="font-semibold mb-3">Order summary</h2>
                    <dl class="space-y-2 text-sm">
                        <div class="flex justify-between gap-3">
                            <dt class="text-gray-600">Order ID</dt>
                            <dd class="font-medium">#{{ $order->id }}</dd>
                        </div>
                        <div class="flex justify-between gap-3">
                            <dt class="text-gray-600">Items count</dt>
                            <dd>{{ $order->items->count() }}</dd>
                        </div>
                        <div class="flex justify-between gap-3">
                            <dt class="text-gray-600">Items subtotal</dt>
                            <dd>₹{{ number_format($itemsSubtotal, 2) }}</dd>
                        </div>
                        <div class="flex justify-between gap-3">
                            <dt class="text-gray-600">Loyalty points used</dt>
                            <dd>{{ number_format((int) ($order->loyalty_points_used ?? 0)) }}</dd>
                        </div>
                        <div class="flex justify-between gap-3">
                            <dt class="text-gray-600">Loyalty discount</dt>
                            <dd>- ₹{{ number_format($discountAmount, 2) }}</dd>
                        </div>
                        <div class="flex justify-between gap-3 pt-2 border-t border-gray-200 font-semibold">
                            <dt>Total paid</dt>
                            <dd>₹{{ number_format((float) $order->total, 2) }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="rounded-xl border border-gray-200 p-4">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="font-semibold">Items ordered</h2>
                    <p class="text-xs text-gray-600">Detailed breakup for admin review</p>
                </div>
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full text-left">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="p-2 text-xs font-medium text-gray-600 uppercase">Product</th>
                                <th class="p-2 text-xs font-medium text-gray-600 uppercase text-right">Qty</th>
                                <th class="p-2 text-xs font-medium text-gray-600 uppercase text-right">Unit Price</th>
                                <th class="p-2 text-xs font-medium text-gray-600 uppercase text-right">Line Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                                @php
                                    $qty = max(1, (int) $item->quantity);
                                    $lineTotal = (float) $item->subtotal;
                                    $unitPrice = $lineTotal / $qty;
                                @endphp
                                <tr class="border-b border-gray-200">
                                    <td class="p-2">
                                        @if ($item->product)
                                            <button
                                                type="button"
                                                class="product-view-trigger text-left text-blue-300 hover:underline focus:outline-none"
                                                data-product-name="{{ $item->product->name }}"
                                                data-product-url="{{ route('products.show', $item->product) }}"
                                            >
                                                {{ $item->product->name }}
                                            </button>
                                        @else
                                            {{ 'Product #' . $item->product_id }}
                                        @endif
                                    </td>
                                    <td class="p-2 text-right">{{ $qty }}</td>
                                    <td class="p-2 text-right">₹{{ number_format($unitPrice, 2) }}</td>
                                    <td class="p-2 text-right font-medium">₹{{ number_format($lineTotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="md:hidden space-y-3">
                    @foreach ($order->items as $item)
                        @php
                            $qty = max(1, (int) $item->quantity);
                            $lineTotal = (float) $item->subtotal;
                            $unitPrice = $lineTotal / $qty;
                        @endphp
                        <div class="rounded-lg border border-gray-200 p-3">
                            <p class="font-medium">
                                @if ($item->product)
                                    <button
                                        type="button"
                                        class="product-view-trigger text-left text-blue-300 hover:underline focus:outline-none"
                                        data-product-name="{{ $item->product->name }}"
                                        data-product-url="{{ route('products.show', $item->product) }}"
                                    >
                                        {{ $item->product->name }}
                                    </button>
                                @else
                                    {{ 'Product #' . $item->product_id }}
                                @endif
                            </p>
                            <div class="mt-2 text-sm space-y-1">
                                <div class="flex justify-between"><span class="text-gray-600">Qty</span><span>{{ $qty }}</span></div>
                                <div class="flex justify-between"><span class="text-gray-600">Unit Price</span><span>₹{{ number_format($unitPrice, 2) }}</span></div>
                                <div class="flex justify-between font-medium"><span>Line Total</span><span>₹{{ number_format($lineTotal, 2) }}</span></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="border-t border-gray-200 pt-4">
                <div class="text-sm font-semibold text-gray-700 mb-3">Update status</div>
                <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="flex flex-col sm:flex-row sm:items-center gap-4">
                    @csrf
                    @method('PUT')
                    <label for="order-status" class="text-sm font-medium text-gray-700 shrink-0">Status</label>
                    <select name="status" id="order-status"
                        class="block w-full sm:w-48 min-h-[2.75rem] px-4 py-2.5 text-base text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 focus:outline-none transition appearance-none cursor-pointer"
                        style="background-image: url('data:image/svg+xml;charset=utf-8,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 fill=%22none%22 viewBox=%220 0 24 24%22 stroke=%22%236b7280%22%3E%3Cpath stroke-linecap=%22round%22 stroke-linejoin=%22round%22 stroke-width=%222%22 d=%22M19 9l-7 7-7-7%22/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1.25rem; padding-right: 2.5rem;">
                        @foreach (['pending','paid','shipped','completed','cancelled'] as $s)
                            <option value="{{ $s }}" @selected($order->status === $s)>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg hover:bg-indigo-700 font-medium text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 shrink-0">Update status</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="product-view-modal" class="fixed inset-0 z-[70] hidden" aria-hidden="true">
    <button type="button" id="product-view-overlay" class="absolute inset-0 bg-black/60 backdrop-blur-sm" aria-label="Close"></button>
    <div class="relative flex min-h-full items-center justify-center p-4">
        <div class="w-full max-w-md rounded-2xl border border-white/10 p-4 sm:p-5 shadow-2xl" style="background: #2D3340;">
            <div class="flex items-start justify-between gap-3">
                <h3 class="text-base sm:text-lg font-semibold text-white">View product</h3>
                <button type="button" id="product-view-close" class="text-white/80 hover:text-white text-xl leading-none" aria-label="Close">
                    ×
                </button>
            </div>
            <p class="mt-3 text-sm sm:text-base text-white">
                Do you want to view the product
                <span id="product-view-name" class="font-semibold text-white"></span>?
            </p>
            <div class="mt-5 flex items-center justify-end gap-2 sm:gap-3">
                <button type="button" id="product-view-no" class="px-4 py-2 rounded-lg text-sm font-medium border border-white/20 text-white bg-white/5 hover:bg-white/10">
                    No
                </button>
                <button type="button" id="product-view-yes" class="px-4 py-2 rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                    Yes
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    const modal = document.getElementById('product-view-modal');
    if (!modal) return;

    const nameEl = document.getElementById('product-view-name');
    const overlay = document.getElementById('product-view-overlay');
    const closeBtn = document.getElementById('product-view-close');
    const noBtn = document.getElementById('product-view-no');
    const yesBtn = document.getElementById('product-view-yes');
    const triggers = document.querySelectorAll('.product-view-trigger');
    let targetUrl = '';

    const closeModal = function () {
        modal.classList.add('hidden');
        modal.setAttribute('aria-hidden', 'true');
        targetUrl = '';
    };

    const openModal = function (name, url) {
        targetUrl = url || '';
        nameEl.textContent = name ? '"' + name + '"' : '';
        modal.classList.remove('hidden');
        modal.setAttribute('aria-hidden', 'false');
    };

    triggers.forEach(function (trigger) {
        trigger.addEventListener('click', function () {
            openModal(trigger.getAttribute('data-product-name'), trigger.getAttribute('data-product-url'));
        });
    });

    [overlay, closeBtn, noBtn].forEach(function (el) {
        el.addEventListener('click', closeModal);
    });

    yesBtn.addEventListener('click', function () {
        if (!targetUrl) {
            closeModal();
            return;
        }
        window.location.href = targetUrl;
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });
})();
</script>
@endpush


