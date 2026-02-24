<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto">
    <?php if (isset($component)) { $__componentOriginal360d002b1b676b6f84d43220f22129e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal360d002b1b676b6f84d43220f22129e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumbs','data' => ['items' => ['Products' => route('admin.products.index'), 'Add product' => null]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumbs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['Products' => route('admin.products.index'), 'Add product' => null])]); ?>
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
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="<?php echo e(route('admin.products.store')); ?>" class="space-y-4" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>

                        <!-- 1. Product Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Product Name</label>
                            <input type="text" name="name" value="<?php echo e(old('name')); ?>" class="mt-1 block w-full border rounded-md p-2" required>
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- 2. Product Name (Hindi) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Product Name (Hindi)</label>
                            <input type="text" name="product_name_hi" value="<?php echo e(old('product_name_hi')); ?>" class="mt-1 block w-full border rounded-md p-2">
                        </div>

                        <!-- 3. Brand Name (nullable) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Brand Name</label>
                            <input type="text" name="brand_name" value="<?php echo e(old('brand_name')); ?>" class="mt-1 block w-full border rounded-md p-2">
                        </div>

                        <!-- 4. Local Part Number (nullable) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Local Part Number</label>
                            <input type="text" name="local_part_number" value="<?php echo e(old('local_part_number')); ?>" class="mt-1 block w-full border rounded-md p-2">
                        </div>

                        <!-- 5. Company Part Number (required) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Company Part Number</label>
                            <input type="text" name="company_part_number" value="<?php echo e(old('company_part_number')); ?>" class="mt-1 block w-full border rounded-md p-2" required>
                            <?php $__errorArgs = ['company_part_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- 6. Company Part Number Substitute (nullable) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Company Part Number Substitute</label>
                            <input type="text" name="company_part_number_substitute" value="<?php echo e(old('company_part_number_substitute')); ?>" class="mt-1 block w-full border rounded-md p-2">
                        </div>

                        <!-- 7. Category (required) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Category</label>
                            <input type="text" name="category" value="<?php echo e(old('category')); ?>" class="mt-1 block w-full border rounded-md p-2" required>
                            <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Category 2 (optional) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Category 2 (optional)</label>
                            <input type="text" name="category_2" value="<?php echo e(old('category_2')); ?>" class="mt-1 block w-full border rounded-md p-2">
                            <?php $__errorArgs = ['category_2'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Category 3 (optional) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Category 3 (optional)</label>
                            <input type="text" name="category_3" value="<?php echo e(old('category_3')); ?>" class="mt-1 block w-full border rounded-md p-2">
                            <?php $__errorArgs = ['category_3'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Category 4 (optional) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Category 4 (optional)</label>
                            <input type="text" name="category_4" value="<?php echo e(old('category_4')); ?>" class="mt-1 block w-full border rounded-md p-2">
                            <?php $__errorArgs = ['category_4'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- 8. MRP (price) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">MRP</label>
                            <input type="number" name="price" step="0.01" value="<?php echo e(old('price')); ?>" class="mt-1 block w-full border rounded-md p-2">
                            <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Stock -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Stock</label>
                            <input type="number" name="stock" min="0" value="<?php echo e(old('stock', 0)); ?>" class="mt-1 block w-full border rounded-md p-2">
                            <?php $__errorArgs = ['stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- 9. DLP (nullable) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">DLP</label>
                            <input type="number" name="dlp" step="0.01" value="<?php echo e(old('dlp')); ?>" class="mt-1 block w-full border rounded-md p-2">
                        </div>

                        <!-- 10. Unit (nullable) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Unit</label>
                            <input type="text" name="unit" value="<?php echo e(old('unit')); ?>" class="mt-1 block w-full border rounded-md p-2">
                        </div>

                        <!-- 11. Image upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Image</label>
                            <input type="file" name="image" class="mt-1 block w-full border rounded-md p-2" accept="image/*">
                        </div>

                        <button class="bg-indigo-600 text-white px-4 py-2 rounded-md">Create</button>
                    </form>
                </div>
            </div>
        </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Admin\clean\complete ecom before mass upload - Copy\resources\views/admin/products/create.blade.php ENDPATH**/ ?>