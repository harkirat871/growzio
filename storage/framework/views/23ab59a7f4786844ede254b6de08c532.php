<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <li class="category-item" data-category-id="<?php echo e($category->id); ?>">
        <div class="px-4 py-3 flex items-center justify-between admin-row-hover">
            <div class="flex items-center flex-1">
                <span class="category-toggle mr-2 cursor-pointer" style="color: var(--admin-text-muted, #71717a);" onclick="toggleCategory(<?php echo e($category->id); ?>)">
                    <?php if($category->children->isNotEmpty()): ?>
                        <span class="expand-icon" id="icon-<?php echo e($category->id); ?>">▼</span>
                    <?php else: ?>
                        <span class="text-gray-400">-</span>
                    <?php endif; ?>
                </span>
                <div class="flex-1">
                    <span class="text-sm font-medium text-gray-900"><?php echo e($category->name); ?></span>
                    <button type="button"
                            class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 hover:bg-blue-200 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-300"
                            onclick="if(confirm(<?php echo e(json_encode('Would you like to see what products are there in ' . $category->name . '?')); ?>)) { window.location.href='<?php echo e(route('products.byCategory', $category)); ?>'; }">
                        <?php echo e($category->products_count ?? 0); ?> products
                    </button>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="<?php echo e(route('admin.categories.edit', $category)); ?>" 
                   class="inline-flex items-center px-3 py-1.5 border text-sm font-medium rounded-md admin-edit-btn focus:outline-none">
                    Edit
                </a>
                <form action="<?php echo e(route('admin.categories.destroy', $category)); ?>" method="POST" class="inline">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" 
                            class="inline-flex items-center px-3 py-1.5 border text-sm font-medium rounded-md admin-delete-btn focus:outline-none" 
                            onclick="return confirm('Are you sure you want to delete this category?')">
                        Delete
                    </button>
                </form>
            </div>
        </div>
        <?php if($category->children->isNotEmpty()): ?>
            <ul class="children-list ml-6" id="children-<?php echo e($category->id); ?>">
                <?php echo $__env->make('admin.categories._tree', ['categories' => $category->children], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </ul>
        <?php endif; ?>
    </li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH C:\Users\Admin\clean\complete ecom before mass upload - Copy\resources\views/admin/categories/_tree.blade.php ENDPATH**/ ?>