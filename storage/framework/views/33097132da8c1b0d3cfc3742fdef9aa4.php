<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <li class="unity-category-item" data-category-id="<?php echo e($cat->id); ?>">
        <div class="unity-category-row">
            <div style="display:flex;align-items:center;gap:0.5rem;flex:1;">
                <?php if($cat->relationLoaded('children') && $cat->children->isNotEmpty()): ?>
                    <span class="unity-category-toggle" onclick="toggleUnityCategory(<?php echo e($cat->id); ?>)" role="button" aria-expanded="false" aria-controls="unity-children-<?php echo e($cat->id); ?>" tabindex="0">
                        <span id="unity-icon-<?php echo e($cat->id); ?>" aria-hidden="true">▶</span>
                    </span>
                <?php else: ?>
                    <span style="width:1em;display:inline-block;">−</span>
                <?php endif; ?>
                <span class="unity-category-name"><?php echo e($cat->name); ?></span>
            </div>
            <a href="<?php echo e(route('products.byCategory', $cat)); ?>" class="unity-category-link">
                View
                <?php if(isset($cat->products_count)): ?>
                    <span>(<?php echo e($cat->products_count); ?>)</span>
                <?php endif; ?>
            </a>
        </div>
        <?php if($cat->relationLoaded('children') && $cat->children->isNotEmpty()): ?>
            <ul class="unity-category-children hidden" id="unity-children-<?php echo e($cat->id); ?>" role="group" style="list-style:none;margin:0;padding-left:1rem;">
                <?php echo $__env->make('products.categories._tree_unity', ['categories' => $cat->children], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </ul>
        <?php endif; ?>
    </li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH C:\Users\Admin\clean\complete ecom before mass upload - Copy\resources\views/products/categories/_tree_unity.blade.php ENDPATH**/ ?>