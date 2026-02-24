<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - Premium Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #0A0A0A;
            --secondary: #1A1A1A;
            --accent: #2563EB;
            --text-primary: #FFFFFF;
            --text-secondary: #A1A1AA;
            --border: rgba(255, 255, 255, 0.08);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--primary);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', system-ui, sans-serif;
            color: var(--text-primary);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Navbar */
        .custom-navbar {
            background: rgba(10, 10, 10, 0.8);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            padding: 1rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1050;
        }

        .navbar-brand {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            letter-spacing: -0.02em;
        }

        .navbar-brand i {
            color: var(--accent);
        }

        .nav-link {
            color: var(--text-secondary) !important;
            font-weight: 500;
            font-size: 0.9rem;
            transition: color 0.2s ease;
            padding: 0.5rem 1rem !important;
        }

        .nav-link:hover {
            color: var(--text-primary) !important;
        }

        /* Main Content */
        .main-content {
            margin-top: 73px;
            min-height: calc(100vh - 73px);
            padding: 3rem 0;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        /* Guest Notice */
        .guest-notice {
            background: rgba(37, 99, 235, 0.1);
            border: 1px solid rgba(37, 99, 235, 0.2);
            border-radius: 8px;
            padding: 1rem 1.25rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: start;
            gap: 1rem;
        }

        .guest-notice i {
            color: var(--accent);
            font-size: 1.25rem;
            margin-top: 0.125rem;
        }

        .guest-notice-content h3 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .guest-notice-content p {
            font-size: 0.9rem;
            color: var(--text-secondary);
            margin: 0;
        }

        .guest-notice-content a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 500;
        }

        .guest-notice-content a:hover {
            text-decoration: underline;
        }

        /* Cart Card */
        .cart-card {
            background: var(--secondary);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }

        .cart-content {
            padding: 2rem;
        }

        /* Cart Item */
        .cart-item {
            background: var(--primary);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            display: flex;
            gap: 1.25rem;
            align-items: center;
        }

        .cart-item:last-child {
            margin-bottom: 0;
        }

        .cart-item-image {
            flex-shrink: 0;
            width: 80px;
            height: 80px;
            border-radius: 8px;
            overflow: hidden;
            background: var(--secondary);
            border: 1px solid var(--border);
        }

        .cart-item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .cart-item-image-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
        }

        .cart-item-details {
            flex: 1;
            min-width: 0;
        }

        .cart-item-name {
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .cart-item-price {
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin-bottom: 0.75rem;
        }

        .cart-item-quantity {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .quantity-input {
            background: var(--secondary);
            border: 1px solid var(--border);
            color: var(--text-primary);
            border-radius: 6px;
            padding: 0.5rem 0.75rem;
            font-size: 0.9rem;
            width: 70px;
            min-height: 44px;
            text-align: center;
        }

        .quantity-input:focus {
            outline: none;
            border-color: var(--accent);
        }

        .btn-update {
            background: var(--accent);
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            min-height: 44px;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-update:hover {
            background: #1d4ed8;
        }

        .cart-item-actions {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 0.75rem;
        }

        .cart-item-subtotal {
            font-size: 1.125rem;
            font-weight: 600;
        }

        .btn-remove {
            background: transparent;
            border: none;
            color: #ef4444;
            font-size: 0.875rem;
            padding: 0.5rem 0.75rem;
            min-height: 44px;
            cursor: pointer;
            transition: color 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-remove:hover {
            color: #dc2626;
            text-decoration: underline;
        }

        /* Cart Summary */
        .cart-summary {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .cart-total {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .cart-actions {
            display: flex;
            gap: 0.75rem;
        }

        .btn-clear {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--text-primary);
            padding: 0.75rem 1.5rem;
            min-height: 44px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-clear:hover {
            background: var(--secondary);
            border-color: var(--text-secondary);
        }

        .btn-checkout {
            background: var(--accent);
            border: none;
            color: white;
            padding: 0.75rem 2rem;
            min-height: 44px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-checkout:hover {
            background: #1d4ed8;
            color: white;
            transform: translateY(-1px);
        }

        /* Empty Cart */
        .empty-cart {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-cart i {
            font-size: 4rem;
            color: var(--text-secondary);
            margin-bottom: 1.5rem;
        }

        .empty-cart h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .empty-cart p {
            color: var(--text-secondary);
            margin-bottom: 2rem;
        }

        /* Dropdown */
        .dropdown-menu {
            background: var(--secondary);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 0.5rem;
        }

        .dropdown-item {
            color: var(--text-primary);
            border-radius: 6px;
            padding: 0.5rem 1rem;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background: var(--primary);
            color: var(--text-primary);
        }

        .dropdown-divider {
            border-color: var(--border);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .cart-content {
                padding: 1.5rem;
            }

            .cart-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .cart-item-actions {
                width: 100%;
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }

            .cart-summary {
                flex-direction: column;
                align-items: stretch;
            }

            .cart-actions {
                flex-direction: column;
            }

            .page-title {
                font-size: 1.5rem;
            }
        }

        /* Sticky bottom bar: mobile only, fixed to viewport like header */
        .cart-sticky-bottom {
            display: none !important;
        }
        @media (max-width: 768px) {
            .cart-sticky-bottom {
                display: flex !important;
                position: fixed !important;
                bottom: 0 !important;
                left: 0 !important;
                right: 0 !important;
                width: 100% !important;
                background: var(--secondary);
                border-top: 1px solid var(--border);
                padding: 0.75rem 1rem;
                padding-bottom: max(0.75rem, env(safe-area-inset-bottom));
                z-index: 1050;
                align-items: center;
                justify-content: space-between;
                gap: 0.75rem;
                box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.3);
                -webkit-transform: translateZ(0);
                transform: translateZ(0);
            }
            .cart-sticky-bottom .sticky-view-cart {
                background: transparent;
                border: 1px solid var(--border);
                color: var(--text-primary);
                padding: 0.5rem 0.75rem;
                border-radius: 8px;
                font-size: 0.8rem;
                font-weight: 500;
                cursor: pointer;
                display: inline-flex;
                align-items: center;
            }
            .cart-sticky-bottom .sticky-view-cart:hover {
                background: var(--primary);
                border-color: var(--text-secondary);
            }
            .cart-sticky-bottom .sticky-total {
                font-size: 1.125rem;
                font-weight: 700;
            }
            .cart-sticky-bottom .sticky-checkout {
                min-height: 44px;
                padding: 0 1.5rem;
                background: var(--accent);
                color: white;
                border-radius: 8px;
                font-weight: 600;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }
            .cart-sticky-bottom .sticky-checkout:hover {
                background: #1d4ed8;
                color: white;
            }
            body.cart-has-sticky { padding-bottom: 70px; }
        }
    </style>
</head>
<body class="<?php if($items->count()): ?> cart-has-sticky <?php endif; ?>">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg custom-navbar">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-gem me-2"></i>Premium Store
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('home')); ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('home')); ?>">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('cart.view')); ?>">
                            <i class="fas fa-shopping-cart me-1"></i>Cart
                        </a>
                    </li>
                    <?php if(auth()->guard()->check()): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i><?php echo e(Auth::user()->name); ?>

                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
                                <li><a class="dropdown-item" href="<?php echo e(route('profile.edit')); ?>">Profile</a></li>
                                <?php if(Auth::user()->is_admin): ?>
                                    <li><a class="dropdown-item" href="<?php echo e(route('admin.products.index')); ?>">Admin Panel</a></li>
                                <?php endif; ?>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="<?php echo e(route('logout')); ?>" onsubmit="return confirm('Are you sure you want to log out?');">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="dropdown-item">Log Out</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('login')); ?>">
                                <i class="fas fa-sign-in-alt me-1"></i>Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('register')); ?>">
                                <i class="fas fa-user-plus me-1"></i>Register
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container" style="max-width: 900px;">
            <div class="page-header">
                <h1 class="page-title">Your Cart</h1>
            </div>

            <!-- Guest Notice -->
            <?php if(auth()->guard()->guest()): ?>
                <div class="guest-notice">
                    <i class="fas fa-info-circle"></i>
                    <div class="guest-notice-content">
                        <h3>Guest User</h3>
                        <p>You're viewing your cart as a guest. 
                            <a href="<?php echo e(route('login')); ?>">Login</a> or 
                            <a href="<?php echo e(route('register')); ?>">register</a> 
                            to save your cart and proceed to checkout.</p>
                    </div>
                </div>
            <?php endif; ?>

            <div class="cart-card" id="cart-content">
                <div class="cart-content">
                    <?php if($items->count()): ?>
                        <!-- Cart Items -->
                        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="cart-item">
                                <div class="cart-item-image">
                                    <?php if($item['product']->image_path): ?>
                                        <img src="<?php echo e(asset($item['product']->image_path)); ?>" alt="<?php echo e($item['product']->name); ?>">
                                    <?php else: ?>
                                        <div class="cart-item-image-placeholder">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="cart-item-details">
                                    <div class="cart-item-name"><?php echo e($item['product']->name); ?></div>
                                    <div class="cart-item-price">₹<?php echo e(number_format($item['product']->price, 2)); ?> each</div>
                                    <form method="POST" action="<?php echo e(route('cart.update', $item['product'])); ?>" class="cart-item-quantity">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <input type="number" name="quantity" value="<?php echo e($item['quantity']); ?>" min="1" class="quantity-input">
                                        <button type="submit" class="btn-update">Update</button>
                                    </form>
                                </div>
                                
                                <div class="cart-item-actions">
                                    <div class="cart-item-subtotal">₹<?php echo e(number_format($item['subtotal'], 2)); ?></div>
                                    <form method="POST" action="<?php echo e(route('cart.remove', $item['product'])); ?>">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn-remove">Remove</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <!-- Loyalty points (cart only, authenticated users) -->
                        <?php if(auth()->guard()->check()): ?>
                        <?php if($loyaltyPointsAvailable > 0): ?>
                        <div class="cart-loyalty border rounded p-4 mb-4" style="background: var(--secondary); border-color: var(--border) !important;">
                            <h4 class="mb-2" style="font-size: 1rem; font-weight: 600;">Use loyalty points</h4>
                            <p class="text-small mb-3" style="font-size: 0.8rem; color: var(--text-secondary);">10 points = ₹1 discount. You have <strong><?php echo e($loyaltyPointsAvailable); ?></strong> points.</p>
                            <form method="POST" action="<?php echo e(route('cart.loyalty')); ?>" class="d-flex flex-wrap align-items-end gap-2 mb-3">
                                <?php echo csrf_field(); ?>
                                <div>
                                    <label class="form-label mb-0" style="font-size: 0.8rem;">Points to use</label>
                                    <input type="number" name="loyalty_points_to_use" class="quantity-input" value="<?php echo e($loyaltyPointsToUse); ?>" min="0" max="<?php echo e($loyaltyPointsAvailable); ?>" step="10" style="width: 100px;">
                                </div>
                                <button type="submit" class="btn-update">Apply</button>
                            </form>
                            <?php if($loyaltyPointsToUse > 0): ?>
                                <p class="mb-0 small" style="color: var(--text-secondary);">Discount: ₹<?php echo e(number_format($loyaltyDiscountAmount, 2)); ?> · Remaining points after checkout: <strong><?php echo e($remainingPoints); ?></strong></p>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                        <?php endif; ?>

                        <!-- Cart Summary -->
                        <div class="cart-summary">
                            <div class="d-flex flex-column gap-1 w-100">
                                <div class="d-flex justify-content-between" style="color: var(--text-secondary); font-size: 0.9rem;">
                                    <span>Subtotal</span>
                                    <span>₹<?php echo e(number_format($subtotal, 2)); ?></span>
                                </div>
                                <?php if(auth()->guard()->check()): ?>
                                <?php if($loyaltyDiscountAmount > 0): ?>
                                <div class="d-flex justify-content-between" style="color: var(--text-secondary); font-size: 0.9rem;">
                                    <span>Loyalty discount</span>
                                    <span>-₹<?php echo e(number_format($loyaltyDiscountAmount, 2)); ?></span>
                                </div>
                                <?php endif; ?>
                                <?php endif; ?>
                                <div class="cart-total">Total: ₹<?php echo e(number_format($total, 2)); ?></div>
                            </div>
                            <div class="cart-actions">
                                <form method="POST" action="<?php echo e(route('cart.clear')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn-clear">Clear Cart</button>
                                </form>
                                <?php if(auth()->guard()->check()): ?>
                                    <a href="<?php echo e(route('checkout.form')); ?>" class="btn-checkout">Checkout</a>
                                <?php else: ?>
                                    <a href="<?php echo e(route('checkout.login-required')); ?>" class="btn-checkout">Proceed to Checkout</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- Empty Cart -->
                        <div class="empty-cart">
                            <i class="fas fa-shopping-cart"></i>
                            <h3>Your cart is empty</h3>
                            <p>Looks like you haven't added any products to your cart yet.</p>
                            <a href="<?php echo e(route('home')); ?>" class="btn-checkout">Continue Shopping</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php if($items->count()): ?>
    <!-- Sticky bottom bar: mobile only, fixed to bottom of screen like header -->
    <div class="cart-sticky-bottom">
        <button type="button" class="sticky-view-cart" onclick="document.getElementById('cart-content').scrollIntoView({ behavior: 'smooth', block: 'start' })" aria-label="View cart">
            <i class="fas fa-shopping-cart me-1"></i> View cart
        </button>
        <span class="sticky-total">₹<?php echo e(number_format($total, 2)); ?></span>
        <?php if(auth()->guard()->check()): ?>
            <a href="<?php echo e(route('checkout.form')); ?>" class="sticky-checkout">Checkout</a>
        <?php else: ?>
            <a href="<?php echo e(route('checkout.login-required')); ?>" class="sticky-checkout">Proceed to Checkout</a>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> <?php /**PATH C:\Users\Admin\clean\complete ecom before mass upload - Copy\resources\views/cart/index.blade.php ENDPATH**/ ?>