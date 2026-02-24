<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto">
    <?php if (isset($component)) { $__componentOriginal360d002b1b676b6f84d43220f22129e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal360d002b1b676b6f84d43220f22129e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumbs','data' => ['items' => ['Products' => route('admin.products.index'), 'Edit' => null]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumbs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['Products' => route('admin.products.index'), 'Edit' => null])]); ?>
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
            <form method="POST" action="<?php echo e(route('admin.products.update', $product)); ?>" class="space-y-6" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                
                <details open class="group border border-gray-200 rounded-lg">
                    <summary class="flex items-center justify-between cursor-pointer list-none px-4 py-3 bg-gray-50 rounded-t-lg hover:bg-gray-100">
                        <span class="font-medium text-gray-900">Basic info</span>
                        <span class="text-gray-400 group-open:rotate-180 transition-transform">▼</span>
                    </summary>
                    <div class="p-4 space-y-4 border-t border-gray-200">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Product Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-indigo-500 focus:ring-indigo-500" value="<?php echo e(old('name', $product->name)); ?>" required>
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Product Name (Hindi)</label>
                            <input type="text" name="product_name_hi" class="mt-1 block w-full border border-gray-300 rounded-md p-2" value="<?php echo e(old('product_name_hi', $product->product_name_hi)); ?>">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Brand Name</label>
                            <input type="text" name="brand_name" class="mt-1 block w-full border border-gray-300 rounded-md p-2" value="<?php echo e(old('brand_name', $product->brand_name)); ?>">
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">MRP (Price)</label>
                                <input type="number" name="price" step="0.01" class="mt-1 block w-full border border-gray-300 rounded-md p-2" value="<?php echo e(old('price', $product->price)); ?>">
                                <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Stock</label>
                                <input type="number" name="stock" min="0" class="mt-1 block w-full border border-gray-300 rounded-md p-2" value="<?php echo e(old('stock', $product->stock)); ?>">
                                <?php $__errorArgs = ['stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>
                </details>

                
                <details class="group border border-gray-200 rounded-lg">
                    <summary class="flex items-center justify-between cursor-pointer list-none px-4 py-3 bg-gray-50 rounded-t-lg hover:bg-gray-100">
                        <span class="font-medium text-gray-900">Identifiers & part numbers</span>
                        <span class="text-gray-400 group-open:rotate-180 transition-transform">▼</span>
                    </summary>
                    <div class="p-4 space-y-4 border-t border-gray-200">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Company Part Number <span class="text-red-500">*</span></label>
                            <input type="text" name="company_part_number" class="mt-1 block w-full border border-gray-300 rounded-md p-2" value="<?php echo e(old('company_part_number', $product->company_part_number)); ?>" required>
                            <?php $__errorArgs = ['company_part_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Local Part Number</label>
                            <input type="text" name="local_part_number" class="mt-1 block w-full border border-gray-300 rounded-md p-2" value="<?php echo e(old('local_part_number', $product->local_part_number)); ?>">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Company Part Number Substitute</label>
                            <input type="text" name="company_part_number_substitute" class="mt-1 block w-full border border-gray-300 rounded-md p-2" value="<?php echo e(old('company_part_number_substitute', $product->company_part_number_substitute)); ?>">
                        </div>
                    </div>
                </details>

                
                <details class="group border border-gray-200 rounded-lg">
                    <summary class="flex items-center justify-between cursor-pointer list-none px-4 py-3 bg-gray-50 rounded-t-lg hover:bg-gray-100">
                        <span class="font-medium text-gray-900">Categories</span>
                        <span class="text-gray-400 group-open:rotate-180 transition-transform">▼</span>
                    </summary>
                    <div class="p-4 space-y-4 border-t border-gray-200">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Category <span class="text-red-500">*</span></label>
                            <input type="text" name="category" value="<?php echo e(old('category', optional($product->category)->name)); ?>" class="mt-1 block w-full border border-gray-300 rounded-md p-2" required>
                            <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Category 2 (optional)</label>
                                <input type="text" name="category_2" value="<?php echo e(old('category_2', optional($product->category2)->name)); ?>" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                                <?php $__errorArgs = ['category_2'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Category 3 (optional)</label>
                                <input type="text" name="category_3" value="<?php echo e(old('category_3', optional($product->category3)->name)); ?>" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                                <?php $__errorArgs = ['category_3'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Category 4 (optional)</label>
                            <input type="text" name="category_4" value="<?php echo e(old('category_4', optional($product->category4)->name)); ?>" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                            <?php $__errorArgs = ['category_4'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </details>

                
                <details class="group border border-gray-200 rounded-lg">
                    <summary class="flex items-center justify-between cursor-pointer list-none px-4 py-3 bg-gray-50 rounded-t-lg hover:bg-gray-100">
                        <span class="font-medium text-gray-900">Pricing & units</span>
                        <span class="text-gray-400 group-open:rotate-180 transition-transform">▼</span>
                    </summary>
                    <div class="p-4 space-y-4 border-t border-gray-200">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">DLP</label>
                                <input type="number" name="dlp" step="0.01" class="mt-1 block w-full border border-gray-300 rounded-md p-2" value="<?php echo e(old('dlp', $product->dlp)); ?>">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Unit</label>
                                <input type="text" name="unit" class="mt-1 block w-full border border-gray-300 rounded-md p-2" value="<?php echo e(old('unit', $product->unit)); ?>">
                            </div>
                        </div>
                    </div>
                </details>

                
                <details class="group border border-gray-200 rounded-lg">
                    <summary class="flex items-center justify-between cursor-pointer list-none px-4 py-3 bg-gray-50 rounded-t-lg hover:bg-gray-100">
                        <span class="font-medium text-gray-900">Image</span>
                        <span class="text-gray-400 group-open:rotate-180 transition-transform">▼</span>
                    </summary>
                    <div class="p-4 border-t border-gray-200">
                        <input type="file" name="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" accept="image/*">
                        <?php if($product->image_path): ?>
                            <img src="<?php echo e(asset($product->image_path)); ?>" alt="<?php echo e($product->name); ?>" class="w-32 h-32 object-cover rounded mt-4">
                        <?php endif; ?>
                    </div>
                </details>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 font-medium">Save changes</button>
                    <a href="<?php echo e(route('admin.products.index')); ?>" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Admin\clean\complete ecom before mass upload - Copy\resources\views/admin/products/edit.blade.php ENDPATH**/ ?>