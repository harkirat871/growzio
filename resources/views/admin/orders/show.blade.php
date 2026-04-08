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

            {{-- 1. CUSTOMER DETAILS --}}
            <div class="rounded-xl border border-gray-200 p-4 relative">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="font-semibold">Customer details</h2>
                    <button type="button" class="copy-section-btn inline-flex items-center gap-1 text-gray-500 hover:text-gray-700 transition" data-section="customer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.75 9.75 0 0 1 3-6.75 2.25 2.25 0 0 1 2.25 2.25v3.375c0 .621.504 1.125 1.125 1.125h6.75c.621 0 1.125.504 1.125 1.125v9.75z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.5h2.625a1.125 1.125 0 0 0 1.125-1.125V2.75" />
                        </svg>
                        <span class="text-xs font-medium">Copy</span>
                    </button>
                </div>
                <dl class="space-y-2 text-sm" id="customer-details-data">
                    <div class="flex justify-between gap-3"><dt class="text-gray-600">Party / Name</dt><dd class="text-right font-medium">{{ $customerName }}</dd></div>
                    <div class="flex justify-between gap-3"><dt class="text-gray-600">Email</dt><dd class="text-right">{{ $customerEmail }}</dd></div>
                    <div class="flex justify-between gap-3"><dt class="text-gray-600">Phone</dt><dd class="text-right">{{ $customerPhone }}</dd></div>
                    <div class="flex justify-between gap-3"><dt class="text-gray-600">Station / Area</dt><dd class="text-right">{{ $customerStation }}</dd></div>
                    <div class="flex justify-between gap-3"><dt class="text-gray-600">Business Name</dt><dd class="text-right">{{ $businessName }}</dd></div>
                    <div class="flex justify-between gap-3"><dt class="text-gray-600">GST</dt><dd class="text-right">{{ $gstNumber }}</dd></div>
                    <div class="flex justify-between gap-3"><dt class="text-gray-600">Referred By</dt><dd class="text-right">{{ $referredBy }}</dd></div>
                    <div class="pt-1 border-t border-gray-200"><dt class="text-gray-600 mb-1">Address</dt><dd class="text-sm">{{ $address }}</dd></div>
                </dl>
            </div>

            {{-- 2. ITEMS ORDERED --}}
            <div class="rounded-xl border border-gray-200 p-4 relative">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="font-semibold">Items ordered</h2>
                    <button type="button" class="copy-section-btn inline-flex items-center gap-1 text-gray-500 hover:text-gray-700 transition" data-section="items">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.75 9.75 0 0 1 3-6.75 2.25 2.25 0 0 1 2.25 2.25v3.375c0 .621.504 1.125 1.125 1.125h6.75c.621 0 1.125.504 1.125 1.125v9.75z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.5h2.625a1.125 1.125 0 0 0 1.125-1.125V2.75" />
                        </svg>
                        <span class="text-xs font-medium">Copy</span>
                    </button>
                </div>
                <div id="items-ordered-data">
                    <div class="hidden md:block overflow-x-auto">
                        <table class="min-w-full text-left">
                            <thead><tr class="border-b border-gray-200"><th class="p-2 text-xs font-medium text-gray-600 uppercase">Product</th><th class="p-2 text-xs font-medium text-gray-600 uppercase text-right">Qty</th><th class="p-2 text-xs font-medium text-gray-600 uppercase text-right">Unit Price</th><th class="p-2 text-xs font-medium text-gray-600 uppercase text-right">Line Total</th></tr></thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                    @php $qty = max(1, (int) $item->quantity); $lineTotal = (float) $item->subtotal; $unitPrice = $lineTotal / $qty; @endphp
                                    <tr class="border-b border-gray-200">
                                        <td class="p-2">{{ $item->product->name ?? 'Product #'.$item->product_id }}</td>
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
                            @php $qty = max(1, (int) $item->quantity); $lineTotal = (float) $item->subtotal; $unitPrice = $lineTotal / $qty; @endphp
                            <div class="rounded-lg border border-gray-200 p-3">
                                <p class="font-medium">{{ $item->product->name ?? 'Product #'.$item->product_id }}</p>
                                <div class="mt-2 text-sm space-y-1"><div class="flex justify-between"><span class="text-gray-600">Qty</span><span>{{ $qty }}</span></div><div class="flex justify-between"><span class="text-gray-600">Unit Price</span><span>₹{{ number_format($unitPrice, 2) }}</span></div><div class="flex justify-between font-medium"><span>Line Total</span><span>₹{{ number_format($lineTotal, 2) }}</span></div></div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- 3. ORDER SUMMARY (at the end) --}}
            <div class="rounded-xl border border-gray-200 p-4 relative">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="font-semibold">Order summary</h2>
                    <button type="button" class="copy-section-btn inline-flex items-center gap-1 text-gray-500 hover:text-gray-700 transition" data-section="summary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.75 9.75 0 0 1 3-6.75 2.25 2.25 0 0 1 2.25 2.25v3.375c0 .621.504 1.125 1.125 1.125h6.75c.621 0 1.125.504 1.125 1.125v9.75z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.5h2.625a1.125 1.125 0 0 0 1.125-1.125V2.75" />
                        </svg>
                        <span class="text-xs font-medium">Copy</span>
                    </button>
                </div>
                <dl class="space-y-2 text-sm" id="order-summary-data">
                    <div class="flex justify-between gap-3"><dt class="text-gray-600">Order ID</dt><dd class="font-medium">#{{ $order->id }}</dd></div>
                    <div class="flex justify-between gap-3"><dt class="text-gray-600">Items count</dt><dd>{{ $order->items->count() }}</dd></div>
                    <div class="flex justify-between gap-3"><dt class="text-gray-600">Items subtotal</dt><dd>₹{{ number_format($itemsSubtotal, 2) }}</dd></div>
                    <div class="flex justify-between gap-3"><dt class="text-gray-600">Loyalty points used</dt><dd>{{ number_format((int) ($order->loyalty_points_used ?? 0)) }}</dd></div>
                    <div class="flex justify-between gap-3"><dt class="text-gray-600">Loyalty discount</dt><dd>- ₹{{ number_format($discountAmount, 2) }}</dd></div>
                    <div class="flex justify-between gap-3 pt-2 border-t border-gray-200 font-semibold"><dt>Total paid</dt><dd>₹{{ number_format((float) $order->total, 2) }}</dd></div>
                </dl>
            </div>

            {{-- Update status form --}}
            <div class="border-t border-gray-200 pt-4">
                <div class="text-sm font-semibold text-gray-700 mb-3">Update status</div>
                <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="flex flex-col sm:flex-row sm:items-center gap-4">
                    @csrf @method('PUT')
                    <label for="order-status" class="text-sm font-medium text-gray-700 shrink-0">Status</label>
                    <select name="status" id="order-status" class="block w-full sm:w-48 min-h-[2.75rem] px-4 py-2.5 text-base text-gray-900 bg-white border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 focus:outline-none transition appearance-none cursor-pointer" style="background-image: url('data:image/svg+xml;charset=utf-8,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 fill=%22none%22 viewBox=%220 0 24 24%22 stroke=%22%236b7280%22%3E%3Cpath stroke-linecap=%22round%22 stroke-linejoin=%22round%22 stroke-width=%222%22 d=%22M19 9l-7 7-7-7%22/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1.25rem; padding-right: 2.5rem;">
                        @foreach (['pending','paid','shipped','completed','cancelled'] as $s) <option value="{{ $s }}" @selected($order->status === $s)>{{ ucfirst($s) }}</option> @endforeach
                    </select>
                    <button type="submit" class="bg-indigo-600 text-white px-5 py-2.5 rounded-lg hover:bg-indigo-700 font-medium text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 shrink-0">Update status</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    function showCopiedMessage(btn) {
        const tooltip = document.createElement('span');
        tooltip.textContent = 'Copied!';
        tooltip.className = 'absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded whitespace-nowrap z-10';
        btn.style.position = 'relative';
        btn.appendChild(tooltip);
        setTimeout(() => { tooltip.remove(); btn.style.position = ''; }, 1500);
    }

    // Helper: format key-value pairs with dynamic spacing (5 spaces gap after longest key)
    function formatKeyValuePairs(elements) {
        let pairs = [];
        elements.forEach(el => {
            const keyEl = el.querySelector('dt');
            const valEl = el.querySelector('dd');
            if (keyEl && valEl) {
                let key = keyEl.innerText.trim();
                let val = valEl.innerText.trim();
                // Skip empty or divider-only lines (like border-t)
                if (key && val && !el.classList.contains('border-t')) pairs.push({key, val});
            }
        });
        // Also handle address separately (special structure)
        const addressDiv = document.querySelector('#customer-details-data .pt-1');
        if (addressDiv) {
            const addrKey = addressDiv.querySelector('dt')?.innerText.trim() || 'Address';
            const addrVal = addressDiv.querySelector('dd')?.innerText.trim() || 'N/A';
            pairs.push({key: addrKey, val: addrVal});
        }
        const maxKeyLen = Math.max(...pairs.map(p => p.key.length), 0);
        return pairs.map(p => p.key + ' '.repeat(maxKeyLen - p.key.length + 5) + p.val).join('\n');
    }

    // Format items ordered as aligned columns (dynamic width)
    function formatItemsOrdered() {
        const rows = document.querySelectorAll('#items-ordered-data .md\\:block tbody tr');
        if (!rows.length) return 'No items found.';
        let data = [];
        // headers
        let headers = ['Product', 'Qty', 'Unit Price', 'Line Total'];
        data.push(headers);
        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            if (cells.length >= 4) {
                let product = cells[0].innerText.trim();
                let qty = cells[1].innerText.trim();
                let unitPrice = cells[2].innerText.trim();
                let lineTotal = cells[3].innerText.trim();
                data.push([product, qty, unitPrice, lineTotal]);
            }
        });
        // compute max width for each column
        let colWidths = headers.map((h, i) => {
            let max = h.length;
            for (let r = 1; r < data.length; r++) {
                max = Math.max(max, data[r][i].length);
            }
            return max;
        });
        // build lines with 2 spaces gap between columns
        let lines = [];
        let headerLine = headers.map((h, i) => h.padEnd(colWidths[i])).join('  ');
        lines.push(headerLine);
        lines.push('-'.repeat(headerLine.length));
        for (let i = 1; i < data.length; i++) {
            let rowLine = data[i].map((cell, j) => cell.padEnd(colWidths[j])).join('  ');
            lines.push(rowLine);
        }
        return lines.join('\n');
    }

    function formatOrderSummary() {
        const container = document.getElementById('order-summary-data');
        const rows = container.querySelectorAll('.flex.justify-between');
        let pairs = [];
        rows.forEach(row => {
            const dt = row.querySelector('dt')?.innerText.trim();
            const dd = row.querySelector('dd')?.innerText.trim();
            if (dt && dd) pairs.push({key: dt, val: dd});
        });
        const maxKeyLen = Math.max(...pairs.map(p => p.key.length), 0);
        return pairs.map(p => p.key + ' '.repeat(maxKeyLen - p.key.length + 5) + p.val).join('\n');
    }

    async function copyText(text, btn) {
        try {
            await navigator.clipboard.writeText(text);
            showCopiedMessage(btn);
        } catch (err) {
            alert('Failed to copy. Manual copy needed.');
        }
    }

    const copyBtns = document.querySelectorAll('.copy-section-btn');
    copyBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const section = btn.getAttribute('data-section');
            let text = '';
            if (section === 'customer') {
                const container = document.getElementById('customer-details-data');
                const rows = container.querySelectorAll('.flex.justify-between:not(.border-t)');
                text = formatKeyValuePairs(rows);
            } else if (section === 'items') {
                text = formatItemsOrdered();
            } else if (section === 'summary') {
                text = formatOrderSummary();
            }
            if (text) copyText(text, btn);
        });
    });
})();
</script>
@endsection