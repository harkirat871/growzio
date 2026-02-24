
<div class="col-6 col-md-4 col-lg-3 unity-product-col">
    <div class="unity-product-card">
        <a href="<?php echo e(route('products.show', $product)); ?>" class="unity-product-link">
            <div class="unity-product-image">
                <?php if($product->image_path): ?>
                    <img src="<?php echo e(asset($product->image_path)); ?>" alt="<?php echo e($product->name); ?>">
                <?php else: ?>
                    <div class="unity-product-image-placeholder">
                        <svg class="unity-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                    </div>
                <?php endif; ?>
            </div>
            <div class="unity-product-details">
                <span class="unity-product-name"><?php echo e($product->name); ?></span>
                <span class="unity-product-price">₹<?php echo e(number_format((float) $product->price, 2)); ?></span>
                <div class="unity-product-meta">
                    <?php if($product->relationLoaded('category') && $product->category): ?>
                        <span class="unity-product-category"><?php echo e($product->category->name); ?></span>
                    <?php endif; ?>
                    <?php if($product->company_part_number): ?>
                        <span class="unity-product-partno"><?php echo e($product->company_part_number); ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </a>
        <div class="unity-product-actions">
            <form method="POST" action="<?php echo e(route('cart.add', $product)); ?>" class="unity-add-form" onclick="event.stopPropagation()">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="unity-btn unity-btn-add">
                    Add to Cart
                </button>
            </form>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\Admin\clean\complete ecom before mass upload - Copy\resources\views/products/_card.blade.php ENDPATH**/ ?>