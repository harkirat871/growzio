<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($product->name); ?> -</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --unity-bg: #FFFFFF;
            --unity-bg-secondary: #F7F7F7;
            --unity-text: #121212;
            --unity-text-secondary: #707070;
            --unity-border: #E8E8E8;
            --unity-ease: cubic-bezier(0.4, 0, 0.2, 1);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            background: var(--unity-bg);
            font-family: 'Inter', -apple-system, sans-serif;
            font-size: 16px;
            line-height: 1.6;
            color: var(--unity-text);
        }

        /* ----- Animations: GPU-friendly, respect reduced motion ----- */
        @media (prefers-reduced-motion: no-preference) {
            .unity-ani-fade-in {
                animation: unityFadeIn 0.5s var(--unity-ease) forwards;
            }
            .unity-ani-delay-1 { animation-delay: 0.06s; }
            .unity-ani-delay-2 { animation-delay: 0.12s; }
            .unity-ani-delay-3 { animation-delay: 0.18s; }
            .unity-ani-delay-4 { animation-delay: 0.24s; }
            .unity-ani-delay-5 { animation-delay: 0.3s; }
            .unity-ani-delay-6 { animation-delay: 0.36s; }
            .unity-ani-hover-lift:hover { transform: translateY(-2px); }
            .unity-ani-hover-scale:hover { transform: scale(1.02); }
        }
        @media (prefers-reduced-motion: reduce) {
            .unity-ani-fade-in { animation: none; opacity: 1; }
            .unity-ani-hover-lift:hover, .unity-ani-hover-scale:hover { transform: none; }
        }
        @keyframes unityFadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ----- Header ----- */
        .unity-header {
            position: sticky;
            top: 0;
            z-index: 1050;
            background: var(--unity-bg);
            border-bottom: 1px solid var(--unity-border);
            padding: 0 1rem;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: box-shadow 0.3s var(--unity-ease);
        }
        .unity-header.scrolled { box-shadow: 0 1px 0 var(--unity-border); }
        .unity-logo { font-size: 1.125rem; font-weight: 600; letter-spacing: -0.02em; color: var(--unity-text); text-decoration: none; }
        .unity-nav-desktop { display: none; }
        @media (min-width: 768px) {
            .unity-nav-desktop { display: flex; align-items: center; gap: 0.25rem; }
            .unity-nav-desktop a { padding: 0.5rem 0.75rem; font-size: 14px; color: var(--unity-text-secondary); text-decoration: none; transition: color 0.2s var(--unity-ease); }
            .unity-nav-desktop a:hover { color: var(--unity-text); }
        }
        .unity-header-right { display: flex; align-items: center; gap: 0.5rem; }
        .unity-icon-btn {
            width: 40px; height: 40px; display: inline-flex; align-items: center; justify-content: center;
            color: var(--unity-text); border: none; background: transparent; cursor: pointer;
            transition: background 0.2s var(--unity-ease), color 0.2s var(--unity-ease);
        }
        .unity-icon-btn:hover { background: var(--unity-bg-secondary); }
        .unity-btn {
            display: inline-flex; align-items: center; justify-content: center; padding: 0.5rem 1rem;
            font-size: 14px; font-family: inherit; font-weight: 500; border-radius: 0; cursor: pointer;
            transition: transform 0.2s var(--unity-ease), background 0.2s var(--unity-ease), border-color 0.2s var(--unity-ease);
            text-decoration: none; border: 1px solid var(--unity-border); background: var(--unity-bg); color: var(--unity-text);
        }
        .unity-btn-primary { background: var(--unity-text); color: var(--unity-bg); border-color: var(--unity-text); }
        .unity-btn-primary:hover { opacity: 0.92; }
        .dropdown-menu { background: var(--unity-bg); border: 1px solid var(--unity-border); border-radius: 0; padding: 0.5rem; }
        .dropdown-item { color: var(--unity-text); padding: 0.5rem 1rem; font-size: 14px; }
        .dropdown-item:hover { background: var(--unity-bg-secondary); }

        /* ----- Main ----- */
        .unity-main { padding: 1.5rem 1rem 3rem; max-width: 1280px; margin: 0 auto; }
        @media (min-width: 992px) { .unity-main { padding: 2rem 2rem 4rem; } }

        .unity-back {
            font-size: 14px; color: var(--unity-text-secondary); text-decoration: none;
            display: inline-flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem;
            transition: color 0.2s var(--unity-ease);
        }
        .unity-back:hover { color: var(--unity-text); }

        /* Product layout */
        .unity-pdp {
            background: var(--unity-bg);
            border: 1px solid var(--unity-border);
            border-radius: 0;
            overflow: hidden;
            margin-bottom: 2rem;
        }
        .unity-pdp-image-wrap {
            background: var(--unity-bg-secondary);
            min-height: 280px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }
        @media (min-width: 992px) { .unity-pdp-image-wrap { min-height: 420px; border-right: 1px solid var(--unity-border); } }
        .unity-pdp-image {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            opacity: 0;
            transition: opacity 0.4s var(--unity-ease);
        }
        .unity-pdp-image.loaded { opacity: 1; }
        .unity-pdp-no-image { color: var(--unity-text-secondary); text-align: center; padding: 2rem; }
        .unity-pdp-info { padding: 1.5rem; }
        @media (min-width: 992px) { .unity-pdp-info { padding: 2rem; } }

        .unity-pdp-badges { display: flex; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 1rem; }
        .unity-pdp-badge {
            font-size: 12px; padding: 0.35rem 0.65rem;
            background: var(--unity-bg-secondary); border: 1px solid var(--unity-border);
            color: var(--unity-text-secondary);
        }
        .unity-pdp-title {
            font-size: 1.5rem; font-weight: 600; letter-spacing: -0.02em; color: var(--unity-text);
            margin-bottom: 0.5rem; line-height: 1.3;
        }
        @media (min-width: 768px) { .unity-pdp-title { font-size: 1.75rem; } }
        .unity-pdp-subtitle { font-size: 14px; color: var(--unity-text-secondary); margin-bottom: 1.25rem; }

        .unity-pdp-details { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 0.75rem; margin-bottom: 1.5rem; }
        .unity-pdp-detail {
            background: var(--unity-bg-secondary);
            border: 1px solid var(--unity-border);
            border-radius: 0;
            padding: 1rem;
        }
        .unity-pdp-detail-label { font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--unity-text-secondary); margin-bottom: 0.35rem; }
        .unity-pdp-detail-value { font-size: 14px; font-weight: 500; color: var(--unity-text); }

        .unity-pdp-price {
            background: var(--unity-bg-secondary);
            border: 1px solid var(--unity-border);
            border-radius: 0;
            padding: 0.5rem 0.75rem;
            width: fit-content;
            margin-bottom: 1.5rem;
        }
        .unity-pdp-price-label { font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--unity-text-secondary); }
        .unity-pdp-price-value { font-size: 1.25rem; font-weight: 600; letter-spacing: -0.02em; color: var(--unity-text); }

        .unity-pdp-cart {
            border: 1px solid var(--unity-border);
            border-radius: 0;
            padding: 1.25rem;
            margin-bottom: 1rem;
        }
        .unity-pdp-qty { margin-bottom: 1rem; }
        .unity-pdp-qty label { font-size: 14px; color: var(--unity-text-secondary); margin-right: 0.5rem; }
        .unity-pdp-qty input {
            width: 72px; padding: 0.5rem; font-size: 14px; font-family: inherit;
            border: 1px solid var(--unity-border); border-radius: 0; background: var(--unity-bg);
        }
        .unity-pdp-add {
            width: 100%;
            padding: 0.875rem 1.5rem;
            font-size: 14px;
            font-weight: 500;
            border-radius: 0;
            border: none;
            background: var(--unity-text);
            color: var(--unity-bg);
            cursor: pointer;
            transition: transform 0.2s var(--unity-ease), opacity 0.2s var(--unity-ease);
        }
        @media (prefers-reduced-motion: no-preference) {
            .unity-pdp-add:hover { transform: scale(1.02); opacity: 0.95; }
        }
        .unity-pdp-add:disabled { opacity: 0.6; cursor: not-allowed; }

        .unity-pdp-desc {
            border: 1px solid var(--unity-border);
            border-radius: 0;
            padding: 1.25rem;
            margin-top: 1rem;
        }
        .unity-pdp-desc-title { font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--unity-text-secondary); margin-bottom: 0.75rem; }
        .unity-pdp-desc-text { font-size: 14px; color: var(--unity-text); line-height: 1.6; white-space: pre-wrap; }
        .unity-pdp-desc-toggle {
            font-size: 13px; color: var(--unity-text-secondary); background: none; border: none; padding: 0.5rem 0; margin-top: 0.5rem; cursor: pointer;
            display: inline-flex; align-items: center; gap: 0.25rem;
        }
        .unity-pdp-desc-toggle:hover { color: var(--unity-text); }
        @media (min-width: 768px) { .unity-pdp-desc-text.is-clamped { max-height: none; } }
        @media (max-width: 767px) {
            .unity-pdp-desc-text.is-clamped { max-height: 96px; overflow: hidden; }
        }

        /* You may also like */
        .unity-related {
            padding: 2rem 0;
            border-top: 1px solid var(--unity-border);
        }
        .unity-related-title {
            font-size: 12px; text-transform: uppercase; letter-spacing: 0.15em; color: var(--unity-text-secondary);
            text-align: center; margin-bottom: 1.5rem; font-weight: 600;
        }
        .unity-related-track {
            display: flex;
            gap: 1rem;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            padding: 0.5rem 0;
        }
        .unity-related-track::-webkit-scrollbar { display: none; }
        .unity-related-card {
            flex: 0 0 260px;
            scroll-snap-align: start;
            background: var(--unity-bg);
            border: 1px solid var(--unity-border);
            border-radius: 0;
            overflow: hidden;
            text-decoration: none;
            color: inherit;
            transition: border-color 0.2s var(--unity-ease), transform 0.2s var(--unity-ease);
        }
        @media (prefers-reduced-motion: no-preference) {
            .unity-related-card:hover { border-color: var(--unity-text-secondary); transform: translateY(-2px); }
        }
        .unity-related-card-image {
            aspect-ratio: 4/5;
            background: var(--unity-bg-secondary);
            overflow: hidden;
        }
        .unity-related-card-image img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s var(--unity-ease); }
        .unity-related-card:hover .unity-related-card-image img { transform: scale(1.05); }
        .unity-related-card-body { padding: 1rem; }
        .unity-related-card-title { font-size: 14px; font-weight: 500; color: var(--unity-text); margin-bottom: 0.35rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .unity-related-card-price { font-size: 14px; color: var(--unity-text-secondary); }
        .unity-related-wrap { position: relative; padding: 0 48px; }
        .unity-related-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            border: 1px solid var(--unity-border);
            background: var(--unity-bg);
            color: var(--unity-text);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 1;
            transition: background 0.2s var(--unity-ease), color 0.2s var(--unity-ease);
        }
        .unity-related-btn:hover { background: var(--unity-bg-secondary); }
        .unity-related-btn.prev { left: 0; }
        .unity-related-btn.next { right: 0; }

        /* Toast */
        .cart-toast {
            position: fixed; bottom: 1.5rem; right: 1.5rem; z-index: 9999;
            padding: 0.75rem 1.25rem; background: var(--unity-text); color: var(--unity-bg);
            font-size: 14px; font-weight: 500; border-radius: 0;
            display: flex; align-items: center; gap: 0.5rem;
            animation: unityToastIn 0.3s var(--unity-ease);
        }
        @keyframes unityToastIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; border-radius: 0; }
    </style>
</head>
<body>
    <header class="unity-header" id="unityHeader">
        <div class="d-flex align-items-center gap-3">
            <a href="<?php echo e(route('home')); ?>" class="unity-logo">Make Your Order</a>
            <nav class="unity-nav-desktop">
                <a href="<?php echo e(route('home')); ?>">Home</a>
                <a href="<?php echo e(route('home')); ?>">Products</a>
            </nav>
        </div>
        <div class="unity-header-right">
            <a href="<?php echo e(route('cart.view')); ?>" class="unity-icon-btn" aria-label="Cart">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
            </a>
            <?php if(auth()->guard()->check()): ?>
                <div class="dropdown">
                    <button class="unity-icon-btn" type="button" data-bs-toggle="dropdown" aria-label="Account">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('profile.edit')); ?>">Profile</a></li>
                        <?php if(Auth::user()->isAdmin()): ?>
                            <li><a class="dropdown-item" href="<?php echo e(route('admin.dashboard')); ?>">Admin Panel</a></li>
                        <?php endif; ?>
                        <li><hr class="dropdown-divider"></li>
                        <li><form method="POST" action="<?php echo e(route('logout')); ?>"><?php echo csrf_field(); ?><button type="submit" class="dropdown-item w-100 text-start">Log Out</button></form></li>
                    </ul>
                </div>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" class="unity-btn" style="padding: 0.4rem 0.75rem; font-size: 13px;">Login</a>
                <a href="<?php echo e(route('register')); ?>" class="unity-btn unity-btn-primary" style="padding: 0.4rem 0.75rem; font-size: 13px;">Register</a>
            <?php endif; ?>
        </div>
    </header>

    <main class="unity-main">
        <a href="<?php echo e(route('home')); ?>" class="unity-back unity-ani-fade-in">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Back to Products
        </a>

        <?php if(session('status')): ?>
            <div class="alert alert-success alert-dismissible fade show mb-4 unity-ani-fade-in unity-ani-delay-1">
                <?php echo e(session('status')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="unity-pdp">
            <div class="row g-0">
                <div class="col-lg-5 unity-ani-fade-in unity-ani-delay-1">
                    <div class="unity-pdp-image-wrap">
                        <?php if($product->image_path): ?>
                            <img src="<?php echo e(asset($product->image_path)); ?>" alt="<?php echo e($product->name); ?>" class="unity-pdp-image" id="pdpImage" loading="lazy">
                        <?php else: ?>
                            <div class="unity-pdp-no-image">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                                <p class="mt-2 mb-0">No image</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="unity-pdp-info">
                        <div class="unity-pdp-badges unity-ani-fade-in unity-ani-delay-2">
                            <?php if($product->category): ?>
                                <span class="unity-pdp-badge"><?php echo e($product->category->name); ?></span>
                            <?php endif; ?>
                            <span class="unity-pdp-badge"><?php echo e($product->brand_name ?? '—'); ?></span>
                        </div>
                        <h1 class="unity-pdp-title unity-ani-fade-in unity-ani-delay-2"><?php echo e($product->name); ?></h1>
                        <?php if($product->product_name_hi): ?>
                            <p class="unity-pdp-subtitle unity-ani-fade-in unity-ani-delay-2"><?php echo e($product->product_name_hi); ?></p>
                        <?php endif; ?>

                        <div class="unity-pdp-details">
                            <div class="unity-pdp-detail unity-ani-fade-in unity-ani-delay-3">
                                <div class="unity-pdp-detail-label">Company Part Number</div>
                                <div class="unity-pdp-detail-value"><?php echo e($product->company_part_number ?? '—'); ?></div>
                            </div>
                            <?php if($product->company_part_number_substitute): ?>
                                <div class="unity-pdp-detail unity-ani-fade-in unity-ani-delay-3">
                                    <div class="unity-pdp-detail-label">Alternative Part No.</div>
                                    <div class="unity-pdp-detail-value"><?php echo e($product->company_part_number_substitute); ?></div>
                                </div>
                            <?php endif; ?>
                            <?php if($product->local_part_number): ?>
                                <div class="unity-pdp-detail unity-ani-fade-in unity-ani-delay-3">
                                    <div class="unity-pdp-detail-label">Local Part Number</div>
                                    <div class="unity-pdp-detail-value"><?php echo e($product->local_part_number); ?></div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="unity-pdp-cart unity-ani-fade-in unity-ani-delay-4">
                            <form method="POST" action="<?php echo e(route('cart.add', $product)); ?>">
                                <?php echo csrf_field(); ?>
                                <div class="unity-pdp-qty">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" name="quantity" id="quantity" value="1" min="1">
                                </div>
                                <button type="submit" class="unity-pdp-add">Add to Cart</button>
                            </form>
                            <?php if(auth()->guard()->guest()): ?>
                                <p class="mt-2 mb-0 small text-muted">Guests can add items to cart.</p>
                            <?php endif; ?>
                        </div>

                        <div class="unity-pdp-price unity-ani-fade-in unity-ani-delay-4">
                            <div class="unity-pdp-price-label">MRP</div>
                            <div class="unity-pdp-price-value">₹<?php echo e(number_format((float) $product->price, 2)); ?></div>
                        </div>

                        <?php if($product->description): ?>
                            <div class="unity-pdp-desc unity-ani-fade-in unity-ani-delay-5" id="descSection">
                                <div class="unity-pdp-desc-title">Description</div>
                                <div class="unity-pdp-desc-text is-clamped" id="descText"><?php echo e($product->description); ?></div>
                                <button type="button" class="unity-pdp-desc-toggle d-md-none" id="descToggle" aria-expanded="false">
                                    <span id="descToggleLabel">Read more</span>
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <?php if($youMayAlsoLike->isNotEmpty()): ?>
            <section class="unity-related unity-ani-fade-in unity-ani-delay-6" aria-label="You may also like">
                <h2 class="unity-related-title">You May Also Like</h2>
                <div class="unity-related-wrap">
                    <button type="button" class="unity-related-btn prev" aria-label="Previous" id="relatedPrev">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
                    </button>
                    <button type="button" class="unity-related-btn next" aria-label="Next" id="relatedNext">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
                    </button>
                    <div class="unity-related-track" id="relatedTrack">
                    <?php $__currentLoopData = $youMayAlsoLike; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('products.show', $related)); ?>" class="unity-related-card">
                            <div class="unity-related-card-image">
                                <?php if($related->image_path): ?>
                                    <img src="<?php echo e(asset($related->image_path)); ?>" alt="<?php echo e($related->name); ?>" loading="lazy">
                                <?php else: ?>
                                    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:var(--unity-text-secondary);">
                                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/></svg>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="unity-related-card-body">
                                <div class="unity-related-card-title"><?php echo e($related->name); ?></div>
                                <div class="unity-related-card-price">₹<?php echo e(number_format((float) $related->price, 2)); ?></div>
                            </div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Header scroll
            var header = document.getElementById('unityHeader');
            if (header) window.addEventListener('scroll', function() { header.classList.toggle('scrolled', window.scrollY > 10); });

            // Image fade-in when loaded — class only (no inline opacity so .loaded can show image)
            var img = document.getElementById('pdpImage');
            if (img) {
                if (img.complete) img.classList.add('loaded');
                else img.addEventListener('load', function() { img.classList.add('loaded'); });
            }

            // Cart form AJAX + toast
            var cartForm = document.querySelector('form[action*="/cart/"]');
            if (cartForm) {
                cartForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    var btn = this.querySelector('button[type="submit"]');
                    var orig = btn ? btn.innerHTML : '';
                    if (btn) { btn.innerHTML = 'Adding…'; btn.disabled = true; }
                    fetch(this.action, { method: 'POST', body: new FormData(this), headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(function(r) { return r.json(); })
                        .then(function() {
                            var t = document.createElement('div'); t.id = 'cart-toast'; t.className = 'cart-toast'; t.textContent = 'Added to cart';
                            document.body.appendChild(t);
                            setTimeout(function() { if (t.parentNode) t.remove(); }, 2500);
                            if (btn) { btn.innerHTML = orig; btn.disabled = false; }
                        })
                        .catch(function() { if (btn) { btn.innerHTML = orig; btn.disabled = false; } });
                });
            }

            // Quantity
            var qty = document.getElementById('quantity');
            if (qty) qty.addEventListener('change', function() { var v = parseInt(this.value, 10); if (isNaN(v) || v < 1) this.value = 1; });

            // Description read more (mobile)
            var descSection = document.getElementById('descSection');
            var descToggle = document.getElementById('descToggle');
            var descLabel = document.getElementById('descToggleLabel');
            var descText = document.getElementById('descText');
            if (descSection && descToggle && descLabel && descText) {
                descToggle.addEventListener('click', function() {
                    var open = descSection.classList.toggle('is-expanded');
                    descText.classList.toggle('is-clamped', !open);
                    descLabel.textContent = open ? 'Read less' : 'Read more';
                });
            }

            // Related carousel
            var track = document.getElementById('relatedTrack');
            if (track) {
                var step = Math.min(280, track.offsetWidth * 0.85);
                document.getElementById('relatedPrev').addEventListener('click', function() { track.scrollBy({ left: -step, behavior: 'smooth' }); });
                document.getElementById('relatedNext').addEventListener('click', function() { track.scrollBy({ left: step, behavior: 'smooth' }); });
            }

            // Alert auto-dismiss
            document.querySelectorAll('.alert').forEach(function(a) {
                setTimeout(function() { a.classList.remove('show'); setTimeout(function() { a.remove(); }, 150); }, 5000);
            });
        });
    </script>
</body>
</html>
<?php /**PATH C:\Users\Admin\clean\complete ecom before mass upload - Copy\resources\views/products/show.blade.php ENDPATH**/ ?>