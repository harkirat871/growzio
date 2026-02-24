<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Checkout')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

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
                    <?php if($items->count()): ?>
                        <?php if($loyaltyDiscountAmount > 0): ?>
                        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl">
                            <p class="text-sm font-medium text-emerald-800">Loyalty discount applied: ₹<?php echo e(number_format($loyaltyDiscountAmount, 2)); ?></p>
                            <p class="text-xs text-emerald-700 mt-1">To change loyalty points, go back to <a href="<?php echo e(route('cart.view')); ?>" class="underline font-medium">your cart</a>.</p>
                        </div>
                        <?php endif; ?>

                        <form id="checkout-form" method="POST" action="<?php echo e(route('checkout.store')); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="border-t border-gray-100 pt-6">
                                <h3 class="font-semibold text-gray-900 mb-4">Order summary</h3>
                                <div class="space-y-3">
                                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600"><?php echo e($item['product']->name ?? 'Item'); ?> × <?php echo e($item['quantity']); ?></span>
                                            <span>₹<?php echo e(number_format($item['subtotal'], 2)); ?></span>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($loyaltyDiscountAmount > 0): ?>
                                    <div class="flex justify-between text-sm text-emerald-600">
                                        <span>Loyalty discount</span>
                                        <span>-₹<?php echo e(number_format($loyaltyDiscountAmount, 2)); ?></span>
                                    </div>
                                    <?php endif; ?>
                                    <div class="flex justify-between font-semibold text-base pt-3 border-t border-gray-100">
                                        <span>Total</span>
                                        <span>₹<?php echo e(number_format($total, 2)); ?></span>
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
                    <?php else: ?>
                        <p class="text-gray-600">Your cart is empty. <a href="<?php echo e(route('home')); ?>" class="text-indigo-600 font-medium hover:underline">Continue shopping</a></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php if($items->count()): ?>
    
    <div class="checkout-sticky-bottom">
        <a href="<?php echo e(route('cart.view')); ?>" class="text-sm font-medium text-indigo-600 hover:text-indigo-700">View cart</a>
        <span class="font-semibold text-gray-900">₹<?php echo e(number_format($total, 2)); ?></span>
        <button type="button" class="min-h-[44px] px-6 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 disabled:opacity-70 border-0" id="sticky-place-order">Place order</button>
    </div>
    <?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\Users\Admin\clean\complete ecom before mass upload - Copy\resources\views/checkout/form.blade.php ENDPATH**/ ?>