<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto">
    <?php if (isset($component)) { $__componentOriginal360d002b1b676b6f84d43220f22129e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal360d002b1b676b6f84d43220f22129e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumbs','data' => ['items' => ['Catalog' => null]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumbs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['Catalog' => null])]); ?>
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
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Categories</h1>
            <a href="<?php echo e(route('admin.categories.create')); ?>" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Add New Category
            </a>
        </div>

        <?php if(session('success')): ?>
            <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg border border-gray-200">
            <?php if($rootCategories->count() > 0): ?>
                <ul class="divide-y divide-gray-200">
                    <?php echo $__env->make('admin.categories._tree', ['categories' => $rootCategories], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </ul>
            <?php else: ?>
                <div class="text-center py-12">
                    <p class="text-gray-500">No categories found.</p>
                    <a href="<?php echo e(route('admin.categories.create')); ?>" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                        Add your first category
                    </a>
                </div>
            <?php endif; ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Admin\clean\complete ecom before mass upload - Copy\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>