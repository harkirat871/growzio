<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <style>
        /* Sticky bottom bar: mobile only, fixed to bottom of screen like header */
        .checkout-sticky-bottom {
            display: none !important;
        }
        @media (max-width: 768px) {
            .checkout-sticky-bottom {
                display: flex !important;
                position: fixed !important;
                bottom: 0 !important;
                left: 0 !important;
                right: 0 !important;
                width: 100% !important;
                z-index: 1050 !important;
                align-items: center;
                justify-content: space-between;
                gap: 1rem;
                padding: 0.75rem 1rem;
                padding-bottom: max(0.75rem, env(safe-area-inset-bottom));
                background: #fff;
                border-top: 1px solid #e5e7eb;
                box-shadow: 0 -4px 20px rgba(0,0,0,0.08);
                -webkit-transform: translateZ(0);
                transform: translateZ(0);
            }
            .checkout-sticky-spacer { padding-bottom: 5.5rem !important; }
        }
    </style>

    <div class="py-12 checkout-sticky-spacer">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl">
                <div class="p-6 sm:p-8 text-gray-900">
                    @if ($items->count())
                        @if($loyaltyDiscountAmount > 0)
                        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl">
                            <p class="text-sm font-medium text-emerald-800">Loyalty discount applied: ₹{{ number_format($loyaltyDiscountAmount, 2) }}</p>
                            <p class="text-xs text-emerald-700 mt-1">To change loyalty points, go back to <a href="{{ route('cart.view') }}" class="underline font-medium">your cart</a>.</p>
                        </div>
                        @endif

                        <form id="checkout-form" method="POST" action="{{ route('checkout.store') }}">
                            @csrf
                            <div class="border-t border-gray-100 pt-6">
                                <h3 class="font-semibold text-gray-900 mb-4">Order summary</h3>
                                <div class="space-y-3">
                                    @foreach ($items as $item)
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">{{ $item['product']->name ?? 'Item' }} × {{ $item['quantity'] }}</span>
                                            <span>₹{{ number_format($item['subtotal'], 2) }}</span>
                                        </div>
                                    @endforeach
                                    @if($loyaltyDiscountAmount > 0)
                                    <div class="flex justify-between text-sm text-emerald-600">
                                        <span>Loyalty discount</span>
                                        <span>-₹{{ number_format($loyaltyDiscountAmount, 2) }}</span>
                                    </div>
                                    @endif
                                    <div class="flex justify-between font-semibold text-base pt-3 border-t border-gray-100">
                                        <span>Total</span>
                                        <span>₹{{ number_format($total, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-8">
                                <button type="submit" id="place-order-btn" class="w-full sm:w-auto min-h-[48px] px-8 py-3 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition disabled:opacity-70">
                                    Place order
                                </button>
                            </div>
                        </form>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                var form = document.getElementById('checkout-form');
                                var btn = document.getElementById('place-order-btn');
                                var stickyBtn = document.getElementById('sticky-place-order');
                                if (form && btn) {
                                    form.addEventListener('submit', function() {
                                        btn.disabled = true;
                                        if (btn.textContent) btn.textContent = 'Placing order...';
                                        if (stickyBtn) { stickyBtn.disabled = true; stickyBtn.textContent = 'Placing order...'; }
                                    });
                                }
                                if (stickyBtn && form) {
                                    stickyBtn.addEventListener('click', function() { if (!stickyBtn.disabled) form.requestSubmit(); });
                                }
                            });
                        </script>
                    @else
                        <p class="text-gray-600">Your cart is empty. <a href="{{ route('home') }}" class="text-indigo-600 font-medium hover:underline">Continue shopping</a></p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if ($items->count())
    {{-- Sticky bottom: mobile only, fixed to bottom of screen like header --}}
    <div class="checkout-sticky-bottom">
        <a href="{{ route('cart.view') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700">View cart</a>
        <span class="font-semibold text-gray-900">₹{{ number_format($total, 2) }}</span>
        <button type="button" class="min-h-[44px] px-6 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 disabled:opacity-70 border-0" id="sticky-place-order">Place order</button>
    </div>
    @endif
</x-app-layout>
