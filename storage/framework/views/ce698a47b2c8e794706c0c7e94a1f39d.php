<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <?php if (isset($component)) { $__componentOriginal360d002b1b676b6f84d43220f22129e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal360d002b1b676b6f84d43220f22129e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumbs','data' => ['items' => []]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumbs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal360d002b1b676b6f84d43220f22129e2)): ?>
<?php $attributes = $__attributesOriginal360d002b1b676b6f84d43220f22129e2; ?>
<?php unset($__attributesOriginal360d002b1b676b6f84d43220f22129e2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal360d002b1b676b6f84d43220f22129e2)): ?>
<?php $component = $__componentOriginal360d002b1b676b6f84d43220f22129e2; ?>
<?php unset($__componentOriginal360d002b1b676b6f84d43220f22129e2); ?>
<?php endif; ?>
    <h1 class="text-2xl font-semibold text-gray-900 mb-6">What needs attention</h1>

    
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 mb-8">
        <a href="<?php echo e(route('admin.orders.index', ['status' => 'pending'])); ?>" class="block bg-amber-50 border border-amber-200 rounded-lg p-4 hover:bg-amber-100 transition">
            <div class="flex items-center justify-between">
                <span class="text-sm font-medium text-amber-800">Orders to fulfill</span>
                <span class="text-2xl font-bold text-amber-900"><?php echo e($pendingOrdersCount ?? 0); ?></span>
            </div>
            <p class="mt-1 text-xs text-amber-700">Pending & paid — view and ship</p>
        </a>
        <a href="<?php echo e(route('admin.products.index', ['low_stock' => 1])); ?>" class="block bg-orange-50 border border-orange-200 rounded-lg p-4 hover:bg-orange-100 transition">
            <div class="flex items-center justify-between">
                <span class="text-sm font-medium text-orange-800">Low stock items</span>
                <span class="text-2xl font-bold text-orange-900"><?php echo e($lowStockCount ?? 0); ?></span>
            </div>
            <p class="mt-1 text-xs text-orange-700">Stock ≤ threshold — restock soon</p>
        </a>
        <a href="<?php echo e(route('admin.products.index', ['dead_stock' => 1])); ?>" class="block bg-slate-50 border border-slate-200 rounded-lg p-4 hover:bg-slate-100 transition">
            <div class="flex items-center justify-between">
                <span class="text-sm font-medium text-slate-800">Dead stock</span>
                <span class="text-2xl font-bold text-slate-900"><?php echo e($deadStockCount ?? 0); ?></span>
            </div>
            <p class="mt-1 text-xs text-slate-700">Not sold in 45+ days</p>
        </a>
    </div>

    
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 mb-8">
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-sm text-gray-500">Today's orders</p>
            <p class="text-2xl font-semibold text-gray-900"><?php echo e($todayOrderCount ?? 0); ?></p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-sm text-gray-500">Today's revenue</p>
            <p class="text-2xl font-semibold text-gray-900">₹<?php echo e(number_format($todayRevenue ?? 0, 2)); ?></p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-sm text-gray-500">Total products</p>
            <p class="text-2xl font-semibold text-gray-900"><?php echo e($productCount ?? 0); ?></p>
        </div>
    </div>

    
    <div class="flex flex-wrap gap-3 mb-8">
        <a href="<?php echo e(route('admin.orders.index')); ?>" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">View all orders</a>
        <a href="<?php echo e(route('admin.products.create')); ?>" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50">Add product</a>
        <a href="<?php echo e(route('admin.products.bulk-upload')); ?>" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50">Bulk upload</a>
        <a href="<?php echo e(route('admin.categories.index')); ?>" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50">Manage catalog</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-medium text-gray-900">Orders to fulfill</h2>
                <a href="<?php echo e(route('admin.orders.index')); ?>" class="text-sm text-indigo-600 hover:text-indigo-500">View all</a>
            </div>
            <ul class="divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $pendingOrders ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <li>
                    <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="block px-4 py-3 hover:bg-gray-50">
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-900">#<?php echo e($order->id); ?></span>
                            <span class="text-gray-500"><?php echo e($order->guest_name ?? optional($order->user)->name); ?></span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-500 mt-1">
                            <span><?php echo e(ucfirst($order->status)); ?></span>
                            <span>₹<?php echo e(number_format($order->total, 2)); ?></span>
                        </div>
                    </a>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <li class="px-4 py-8 text-center text-gray-500">No pending orders</li>
                <?php endif; ?>
            </ul>
        </div>

        
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-medium text-gray-900">Recent products</h2>
                <a href="<?php echo e(route('admin.products.index')); ?>" class="text-sm text-indigo-600 hover:text-indigo-500">View all</a>
            </div>
            <ul class="divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $recentProducts ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <li>
                    <a href="<?php echo e(route('admin.products.edit', $product)); ?>" class="block px-4 py-3 hover:bg-gray-50">
                        <div class="flex justify-between">
                            <span class="font-medium text-indigo-600 truncate"><?php echo e($product->name); ?></span>
                            <span class="text-gray-600">₹<?php echo e(number_format($product->price, 2)); ?></span>
                        </div>
                        <div class="text-sm text-gray-500 mt-1">
                            <?php echo e($product->category?->name ?? 'Uncategorized'); ?> · Stock: <?php echo e($product->stock); ?>

                        </div>
                    </a>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <li class="px-4 py-8 text-center text-gray-500">No products yet</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Admin\clean\complete ecom before mass upload - Copy\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>