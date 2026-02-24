<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <li class="category-tree-item" data-category-id="<?php echo e($cat->id); ?>">
        <div class="category-list-row">
            <div class="category-list-row-inner">
                <?php if($cat->relationLoaded('children') && $cat->children->isNotEmpty()): ?>
                    <span class="category-toggle" onclick="toggleCategory(<?php echo e($cat->id); ?>)" role="button" aria-expanded="false" aria-controls="children-<?php echo e($cat->id); ?>" aria-label="Expand subcategories" tabindex="0">
                        <span class="category-expand-icon" id="icon-<?php echo e($cat->id); ?>" aria-hidden="true">▶</span>
                    </span>
                <?php else: ?>
                    <span class="category-toggle category-toggle-disabled" aria-hidden="true">
                        <span class="category-expand-placeholder">−</span>
                    </span>
                <?php endif; ?>
                <span class="category-list-name"><?php echo e($cat->name); ?></span>
            </div>
            <a href="<?php echo e(route('products.byCategory', $cat)); ?>" class="category-view-products" aria-label="View products in <?php echo e($cat->name); ?>">
                View products
                <?php if(isset($cat->products_count)): ?>
                    <span class="category-view-count">(<?php echo e($cat->products_count); ?>)</span>
                <?php endif; ?>
            </a>
        </div>
        <?php if($cat->relationLoaded('children') && $cat->children->isNotEmpty()): ?>
            <ul class="category-children hidden" id="children-<?php echo e($cat->id); ?>" role="group">
                <?php echo $__env->make('products.categories._tree', ['categories' => $cat->children], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </ul>
        <?php endif; ?>
    </li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH C:\Users\Admin\clean\complete ecom before mass upload - Copy\resources\views/products/categories/_tree.blade.php ENDPATH**/ ?>