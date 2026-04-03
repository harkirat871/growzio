{{-- <!DOCTYPE html>
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
<body class="@if(count($items)) cart-has-sticky @endif">
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
                        <a class="nav-link" href="{{route('home')}}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Products</a>
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
                        <a class="nav-link" href="{{ route('cart.view') }}">
                            <i class="fas fa-shopping-cart me-1"></i>Cart
                        </a>
                    </li>
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                                @if(Auth::user()->is_admin)
                                    <li><a class="dropdown-item" href="{{ route('admin.products.index') }}">Admin Panel</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Are you sure you want to log out?');">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Log Out</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i>Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="fas fa-user-plus me-1"></i>Register
                            </a>
                        </li>
                    @endauth
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
            @guest
                <div class="guest-notice">
                    <i class="fas fa-info-circle"></i>
                    <div class="guest-notice-content">
                        <h3>Guest User</h3>
                        <p>You're viewing your cart as a guest. 
                            <a href="{{ route('login') }}">Login</a> or 
                            <a href="{{ route('register') }}">register</a> 
                            to save your cart and proceed to checkout.</p>
                    </div>
                </div>
            @endguest

            <div class="cart-card" id="cart-content">
                <div class="cart-content">
                    @if (count($items))
                        <!-- Cart Items -->
                        @foreach ($items as $item)
                            <div class="cart-item">
                                <div class="cart-item-image">
                                    @if ($item['product']->image_path)
                                        <img src="{{ asset($item['product']->image_path) }}" alt="{{ $item['product']->name }}">
                                    @else
                                        <div class="cart-item-image-placeholder">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="cart-item-details">
                                    <div class="cart-item-name">{{ $item['product']->name }}</div>
                                    <div class="cart-item-price">₹{{ number_format($item['product']->price, 2) }} each</div>
                                    <form method="POST" action="{{ route('cart.update', $item['product']) }}" class="cart-item-quantity">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="quantity-input">
                                        <button type="submit" class="btn-update">Update</button>
                                    </form>
                                </div>
                                
                                <div class="cart-item-actions">
                                    <div class="cart-item-subtotal">₹{{ number_format($item['subtotal'], 2) }}</div>
                                    <form method="POST" action="{{ route('cart.remove', $item['product']) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-remove">Remove</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach

                        <!-- Loyalty points (cart only, authenticated users) -->
                        @auth
                        @if($loyaltyPointsAvailable > 0)
                        <div class="cart-loyalty border rounded p-4 mb-4" style="background: var(--secondary); border-color: var(--border) !important;">
                            <h4 class="mb-2" style="font-size: 1rem; font-weight: 600;">Use loyalty points</h4>
                            <p class="text-small mb-3" style="font-size: 0.8rem; color: var(--text-secondary);">10 points = ₹1 discount. You have <strong>{{ $loyaltyPointsAvailable }}</strong> points.</p>
                            <form method="POST" action="{{ route('cart.loyalty') }}" class="d-flex flex-wrap align-items-end gap-2 mb-3">
                                @csrf
                                <div>
                                    <label class="form-label mb-0" style="font-size: 0.8rem;">Points to use</label>
                                    <input type="number" name="loyalty_points_to_use" class="quantity-input" value="{{ $loyaltyPointsToUse }}" min="0" max="{{ $loyaltyPointsAvailable }}" step="10" style="width: 100px;">
                                </div>
                                <button type="submit" class="btn-update">Apply</button>
                            </form>
                            @if($loyaltyPointsToUse > 0)
                                <p class="mb-0 small" style="color: var(--text-secondary);">Discount: ₹{{ number_format($loyaltyDiscountAmount, 2) }} · Remaining points after checkout: <strong>{{ $remainingPoints }}</strong></p>
                            @endif
                        </div>
                        @endif
                        @endauth

                        <!-- Cart Summary -->
                        <div class="cart-summary">
                            <div class="d-flex flex-column gap-1 w-100">
                                <div class="d-flex justify-content-between" style="color: var(--text-secondary); font-size: 0.9rem;">
                                    <span>Subtotal</span>
                                    <span>₹{{ number_format($subtotal, 2) }}</span>
                                </div>
                                @auth
                                @if($loyaltyDiscountAmount > 0)
                                <div class="d-flex justify-content-between" style="color: var(--text-secondary); font-size: 0.9rem;">
                                    <span>Loyalty discount</span>
                                    <span>-₹{{ number_format($loyaltyDiscountAmount, 2) }}</span>
                                </div>
                                @endif
                                @endauth
                                <div class="cart-total">Total: ₹{{ number_format($total, 2) }}</div>
                            </div>
                            <div class="cart-actions">
                                <form method="POST" action="{{ route('cart.clear') }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-clear">Clear Cart</button>
                                </form>
                                @auth
                                    <a href="{{ route('checkout.form') }}" class="btn-checkout">Checkout</a>
                                @else
                                    <a href="{{ route('checkout.login-required') }}" class="btn-checkout">Proceed to Checkout</a>
                                @endauth
                            </div>
                        </div>
                    @else
                        <!-- Empty Cart -->
                        <div class="empty-cart">
                            <i class="fas fa-shopping-cart"></i>
                            <h3>Your cart is empty</h3>
                            <p>Looks like you haven't added any products to your cart yet.</p>
                            <a href="{{ route('home') }}" class="btn-checkout">Continue Shopping</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if (count($items))
    <!-- Sticky bottom bar: mobile only, fixed to bottom of screen like header -->
    <div class="cart-sticky-bottom">
        <button type="button" class="sticky-view-cart" onclick="document.getElementById('cart-content').scrollIntoView({ behavior: 'smooth', block: 'start' })" aria-label="View cart">
            <i class="fas fa-shopping-cart me-1"></i> View cart
        </button>
        <span class="sticky-total">₹{{ number_format($total, 2) }}</span>
        @auth
            <a href="{{ route('checkout.form') }}" class="sticky-checkout">Checkout</a>
        @else
            <a href="{{ route('checkout.login-required') }}" class="sticky-checkout">Proceed to Checkout</a>
        @endauth
    </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>  --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart · Growzio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        /* =============================================
           GROWZIO — DESIGN SYSTEM (full import)
           ============================================= */
        :root {
            --g-bg:         #222831;
            --g-bg2:        #393E46;
            --g-accent:     #FFD369;
            --g-light:      #EEEEEE;
            --g-text:       #EEEEEE;
            --g-text-muted: rgba(238,238,238,0.55);
            --g-border:     rgba(238,238,238,0.10);
            --g-border-hover: rgba(255,211,105,0.35);
            --g-card-bg:    #2d3340;
            --g-overlay:    rgba(34,40,49,0.85);
            --g-ease:       cubic-bezier(0.4, 0, 0.2, 1);
            --g-ease-spring: cubic-bezier(0.34, 1.56, 0.64, 1);
            --g-radius:     4px;
            --g-radius-lg:  10px;
            --font-head:    'Syne', sans-serif;
            --font-body:    'DM Sans', sans-serif;
            --font-mono:    'JetBrains Mono', monospace;
        }

        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: var(--g-bg2); }
        ::-webkit-scrollbar-thumb { background: var(--g-accent); border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #e8bc52; }
        * { scrollbar-width: thin; scrollbar-color: var(--g-accent) var(--g-bg2); }

        body {
            background: var(--g-bg);
            font-family: var(--font-body);
            font-size: 16px;
            line-height: 1.6;
            color: var(--g-text);
            overflow-x: hidden;
        }

        h1,h2,h3,h4,h5,h6 { font-family: var(--font-head); }
        .mono { font-family: var(--font-mono); }

        /* animations */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(28px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to   { opacity: 1; }
        }
        @keyframes slideRight {
            from { opacity: 0; transform: translateX(-20px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        @keyframes shimmer {
            0%   { background-position: -400px 0; }
            100% { background-position: 400px 0; }
        }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(255,211,105,0.4); }
            50%       { box-shadow: 0 0 0 8px rgba(255,211,105,0); }
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        @keyframes toastSlide {
            from { opacity: 0; transform: translateY(20px) scale(0.95); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        @keyframes logoFloat {
            0%,100% { transform: translateY(0); }
            50%      { transform: translateY(-3px); }
        }
        @keyframes accentBar {
            from { width: 0; }
            to   { width: 48px; }
        }
        @keyframes backTopAppear {
            from { opacity: 0; transform: translateY(10px) scale(0.8); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        .g-reveal {
            opacity: 0;
            transform: translateY(32px);
            transition: opacity 0.65s var(--g-ease), transform 0.65s var(--g-ease);
        }
        .g-reveal.g-revealed {
            opacity: 1;
            transform: translateY(0);
        }

        /* header */
        .g-header {
            position: sticky;
            top: 0;
            z-index: 1050;
            background: rgba(34,40,49,0.92);
            backdrop-filter: blur(18px) saturate(1.5);
            -webkit-backdrop-filter: blur(18px) saturate(1.5);
            border-bottom: 1px solid var(--g-border);
            padding: 0 1.25rem;
            height: 62px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: box-shadow 0.3s var(--g-ease), border-color 0.3s;
        }
        .g-header.scrolled {
            border-bottom-color: rgba(255,211,105,0.18);
            box-shadow: 0 4px 32px rgba(0,0,0,0.35);
        }
        .g-header-left { display: flex; align-items: center; gap: 1.5rem; }
        .g-logo {
            font-family: var(--font-head);
            font-size: 1.35rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: var(--g-light);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            transition: color 0.2s;
        }
        .g-logo span { color: var(--g-accent); }
        .g-logo:hover { animation: logoFloat 0.8s ease; color: var(--g-light); }
        .g-nav-desktop { display: none; }
        @media (min-width: 768px) {
            .g-nav-desktop {
                display: flex;
                align-items: center;
                gap: 0.1rem;
            }
            .g-nav-desktop a {
                padding: 0.45rem 0.85rem;
                font-size: 13.5px;
                font-weight: 500;
                color: var(--g-text-muted);
                text-decoration: none;
                border-radius: var(--g-radius);
                transition: color 0.2s, background 0.2s;
                letter-spacing: 0.01em;
            }
            .g-nav-desktop a:hover,
            .g-nav-desktop a.active {
                color: var(--g-accent);
                background: rgba(255,211,105,0.08);
            }
        }
        .g-header-right { display: flex; align-items: center; gap: 0.4rem; }
        .g-icon-btn {
            width: 40px; height: 40px;
            display: inline-flex; align-items: center; justify-content: center;
            color: var(--g-text-muted);
            border: 1px solid transparent;
            background: transparent;
            border-radius: var(--g-radius);
            cursor: pointer;
            transition: color 0.2s, background 0.2s, border-color 0.2s, transform 0.2s var(--g-ease-spring);
        }
        .g-icon-btn:hover {
            color: var(--g-accent);
            background: rgba(255,211,105,0.08);
            border-color: var(--g-border-hover);
            transform: scale(1.08);
        }
        .g-cart-wrap { position: relative; }
        .g-cart-badge {
            position: absolute;
            top: 3px; right: 3px;
            min-width: 16px; height: 16px;
            padding: 0 4px;
            font-size: 9.5px; font-weight: 700;
            font-family: var(--font-mono);
            color: var(--g-bg);
            background: var(--g-accent);
            border-radius: 50px;
            display: flex; align-items: center; justify-content: center;
        }
        .g-hamburger {
            display: flex; align-items: center; justify-content: center;
            width: 40px; height: 40px;
            border: 1px solid var(--g-border);
            background: transparent;
            color: var(--g-text-muted);
            cursor: pointer;
            border-radius: var(--g-radius);
            transition: all 0.2s;
        }
        .g-hamburger:hover { color: var(--g-accent); border-color: var(--g-border-hover); }
        @media (min-width: 768px) { .g-hamburger { display: none; } }

        .g-btn-ghost {
            padding: 0.38rem 0.9rem;
            font-size: 13px;
            font-family: var(--font-body);
            font-weight: 500;
            color: var(--g-text-muted);
            border: 1px solid var(--g-border);
            background: transparent;
            border-radius: var(--g-radius);
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
        }
        .g-btn-ghost:hover { color: var(--g-light); border-color: rgba(238,238,238,0.3); }
        .g-btn-accent {
            padding: 0.38rem 0.9rem;
            font-size: 13px;
            font-family: var(--font-body);
            font-weight: 600;
            color: var(--g-bg);
            border: 1px solid var(--g-accent);
            background: var(--g-accent);
            border-radius: var(--g-radius);
            text-decoration: none;
            transition: all 0.2s var(--g-ease-spring);
            cursor: pointer;
        }
        .g-btn-accent:hover {
            background: #e8bc52;
            border-color: #e8bc52;
            color: var(--g-bg);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(255,211,105,0.3);
        }

        /* mobile menu */
        .g-mobile-overlay {
            position: fixed; inset: 0;
            background: rgba(34,40,49,0.7);
            backdrop-filter: blur(4px);
            z-index: 1055;
            opacity: 0; visibility: hidden;
            transition: opacity 0.3s, visibility 0.3s;
        }
        .g-mobile-overlay.open { opacity: 1; visibility: visible; }
        .g-mobile-menu {
            position: fixed;
            top: 0; left: 0;
            width: 285px; max-width: 88vw;
            height: 100vh;
            background: var(--g-bg2);
            border-right: 1px solid var(--g-border);
            z-index: 1060;
            transform: translateX(-100%);
            transition: transform 0.35s var(--g-ease);
            overflow-y: auto;
            padding: 1.25rem 0;
            display: flex;
            flex-direction: column;
        }
        .g-mobile-menu.open { transform: translateX(0); }
        .g-mobile-menu-logo {
            padding: 0.5rem 1.25rem 1.25rem;
            font-family: var(--font-head);
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--g-light);
            border-bottom: 1px solid var(--g-border);
            margin-bottom: 0.5rem;
        }
        .g-mobile-menu-logo span { color: var(--g-accent); }
        .g-mobile-menu a {
            display: block;
            padding: 0.75rem 1.25rem;
            font-size: 14px;
            font-weight: 500;
            color: var(--g-text-muted);
            text-decoration: none;
            border-bottom: 1px solid var(--g-border);
            transition: color 0.2s, background 0.2s, padding-left 0.2s;
        }
        .g-mobile-menu a:hover {
            color: var(--g-accent);
            background: rgba(255,211,105,0.05);
            padding-left: 1.6rem;
        }

        /* filter drawer (minimal) */
        .g-filter-overlay {
            position: fixed; inset: 0;
            background: rgba(34,40,49,0.7);
            backdrop-filter: blur(4px);
            z-index: 1055;
            opacity: 0; visibility: hidden;
            transition: opacity 0.3s, visibility 0.3s;
        }
        .g-filter-overlay.open { opacity: 1; visibility: visible; }
        .g-filter-drawer {
            position: fixed; top: 0; right: 0;
            width: 320px; max-width: 90vw;
            height: 100vh;
            background: var(--g-bg2);
            border-left: 1px solid var(--g-border);
            z-index: 1060;
            transform: translateX(100%);
            transition: transform 0.35s var(--g-ease);
            overflow-y: auto;
        }
        .g-filter-drawer.open { transform: translateX(0); }
        .g-filter-header {
            padding: 1.25rem;
            border-bottom: 1px solid var(--g-border);
            font-family: var(--font-head);
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--g-light);
            display: flex; align-items: center; gap: 0.5rem;
        }
        .g-filter-header::before {
            content: '';
            display: inline-block;
            width: 3px; height: 18px;
            background: var(--g-accent);
            border-radius: 2px;
        }
        .g-filter-body { padding: 1.25rem; }

        /* buttons & inputs */
        .g-btn-primary {
            background: var(--g-accent);
            color: var(--g-bg);
            border: 1px solid var(--g-accent);
            font-weight: 600;
            padding: 0.7rem 1.25rem;
            border-radius: var(--g-radius);
            transition: all 0.2s var(--g-ease-spring);
        }
        .g-btn-primary:hover {
            background: #e8bc52;
            transform: translateY(-1px);
            box-shadow: 0 6px 24px rgba(255,211,105,0.28);
        }
        .g-section { padding: 48px 1.25rem; }
        .g-container { max-width: 1320px; margin: 0 auto; }

        /* cart specific */
        .cart-card {
            background: var(--g-card-bg);
            border: 1px solid var(--g-border);
            border-radius: var(--g-radius-lg);
            overflow: hidden;
        }
        .cart-item {
            background: var(--g-bg);
            border: 1px solid var(--g-border);
            border-radius: var(--g-radius);
            padding: 1.25rem;
            margin-bottom: 1rem;
            display: flex;
            gap: 1.25rem;
            align-items: center;
            transition: border-color 0.2s;
        }
        .cart-item:hover { border-color: var(--g-border-hover); }
        .cart-item-image {
            flex-shrink: 0;
            width: 80px;
            height: 80px;
            border-radius: var(--g-radius);
            overflow: hidden;
            background: var(--g-bg2);
            border: 1px solid var(--g-border);
        }
        .cart-item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .cart-item-details { flex: 1; min-width: 0; }
        .cart-item-name {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        .cart-item-name a {
            color: var(--g-light);
            text-decoration: none;
            transition: color 0.2s;
        }
        .cart-item-name a:hover {
            color: var(--g-accent);
            text-decoration: underline;
        }
        .cart-item-price { font-size: 0.8rem; color: var(--g-text-muted); margin-bottom: 0.75rem; }
        .quantity-input {
            background: var(--g-bg2);
            border: 1px solid var(--g-border);
            color: var(--g-text);
            border-radius: var(--g-radius);
            padding: 0.5rem 0.75rem;
            font-size: 0.9rem;
            width: 80px;
            text-align: center;
            font-family: var(--font-mono);
        }
        .quantity-input:focus { outline: none; border-color: var(--g-accent); }
        .btn-update {
            background: var(--g-accent);
            border: none;
            color: var(--g-bg);
            padding: 0.5rem 1rem;
            border-radius: var(--g-radius);
            font-size: 0.8rem;
            font-weight: 600;
            transition: all 0.2s;
        }
        .btn-update:hover { background: #e8bc52; transform: translateY(-1px); }
        .cart-item-subtotal { font-size: 1rem; font-weight: 700; color: var(--g-accent); }
        .btn-remove {
            background: transparent;
            border: none;
            color: #f87171;
            font-size: 0.8rem;
            cursor: pointer;
            transition: color 0.2s;
        }
        .btn-remove:hover { color: #ef4444; text-decoration: underline; }
        .cart-summary {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid var(--g-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .cart-total { font-size: 1.5rem; font-weight: 700; color: var(--g-accent); }
        .btn-clear {
            background: transparent;
            border: 1px solid var(--g-border);
            color: var(--g-text);
            padding: 0.6rem 1.25rem;
            border-radius: var(--g-radius);
            transition: all 0.2s;
        }
        .btn-clear:hover { border-color: var(--g-border-hover); color: var(--g-accent); }
        .btn-checkout {
            background: var(--g-accent);
            color: var(--g-bg);
            padding: 0.6rem 1.75rem;
            border-radius: var(--g-radius);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }
        .btn-checkout:hover { background: #e8bc52; transform: translateY(-1px); color: var(--g-bg); }
        .empty-cart { text-align: center; padding: 4rem 2rem; }
        .empty-cart i { font-size: 3rem; color: var(--g-text-muted); margin-bottom: 1rem; }
        .guest-notice {
            background: rgba(255,211,105,0.08);
            border: 1px solid rgba(255,211,105,0.2);
            border-radius: var(--g-radius-lg);
            padding: 1rem 1.25rem;
            margin-bottom: 2rem;
            display: flex;
            gap: 1rem;
        }
        .guest-notice i { color: var(--g-accent); font-size: 1.2rem; }
        .guest-notice a { color: var(--g-accent); text-decoration: none; font-weight: 500; }
        .guest-notice a:hover { text-decoration: underline; }

        /* loyalty points block */
        .cart-loyalty {
            background: var(--g-bg2);
            border: 1px solid var(--g-border);
            border-radius: var(--g-radius-lg);
            padding: 1.25rem;
            margin-bottom: 1.5rem;
        }

        /* sticky bottom (growzio style) */
        .g-sticky-bottom-cart {
            display: none;
        }
        @media (max-width: 768px) {
            body.cart-has-sticky { padding-bottom: 5rem; }
            .g-sticky-bottom-cart {
                display: flex;
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                z-index: 1040;
                padding: 0.75rem 1rem;
                padding-bottom: max(0.75rem, env(safe-area-inset-bottom));
                background: var(--g-bg2);
                border-top: 1px solid var(--g-border);
                backdrop-filter: blur(10px);
                gap: 0.75rem;
                align-items: center;
                justify-content: space-between;
            }
            .g-sticky-bottom-cart .sticky-total {
                font-weight: 700;
                font-size: 1.1rem;
                color: var(--g-accent);
            }
            .g-sticky-bottom-cart .sticky-view-cart,
            .g-sticky-bottom-cart .sticky-checkout {
                padding: 0.6rem 1rem;
                border-radius: var(--g-radius);
                font-size: 0.8rem;
                font-weight: 600;
                text-decoration: none;
                text-align: center;
                transition: all 0.2s;
            }
            .g-sticky-bottom-cart .sticky-view-cart {
                background: transparent;
                border: 1px solid var(--g-border);
                color: var(--g-text);
            }
            .g-sticky-bottom-cart .sticky-view-cart:hover {
                border-color: var(--g-border-hover);
                color: var(--g-accent);
            }
            .g-sticky-bottom-cart .sticky-checkout {
                background: var(--g-accent);
                color: var(--g-bg);
            }
            .g-sticky-bottom-cart .sticky-checkout:hover {
                background: #e8bc52;
            }
        }

        #g-back-top {
            position: fixed;
            bottom: 1.75rem; right: 1.75rem;
            z-index: 1049;
            width: 44px; height: 44px;
            background: var(--g-accent);
            color: var(--g-bg);
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 20px rgba(255,211,105,0.4);
            transition: transform 0.25s var(--g-ease-spring);
        }
        #g-back-top.visible { display: flex; animation: backTopAppear 0.35s var(--g-ease-spring) both; }
        #g-back-top:hover { background: #e8bc52; transform: translateY(-4px) scale(1.08); }
        @media (max-width: 768px) { #g-back-top { bottom: 5.5rem; right: 1rem; } }

        .dropdown-menu {
            background: var(--g-bg2);
            border: 1px solid var(--g-border);
            border-radius: var(--g-radius-lg);
        }
        .dropdown-item { color: var(--g-text-muted); }
        .dropdown-item:hover { background: rgba(255,211,105,0.08); color: var(--g-accent); }
        .dropdown-divider { border-color: var(--g-border); }

        @media (max-width: 768px) {
            .cart-item { flex-direction: column; align-items: flex-start; }
            .cart-item-actions { width: 100%; flex-direction: row; justify-content: space-between; margin-top: 0.5rem; }
            .cart-summary { flex-direction: column; align-items: stretch; }
            .cart-actions { flex-direction: column; }
        }
    </style>
</head>
<body class="@if(count($items)) cart-has-sticky @endif">
    <!-- ██ HEADER (exactly as index) ██ -->
    <header class="g-header" id="gHeader">
        <div class="g-header-left">
            <button type="button" class="g-hamburger" id="gHamburger" aria-label="Menu">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M3 12h18M3 6h18M3 18h18"/></svg>
            </button>
            <a href="{{ route('home') }}" class="g-logo">Grow<span>zio</span></a>
            <nav class="g-nav-desktop">
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('home') }}">Products</a>
            </nav>
        </div>
        <div class="g-header-right">
            <button type="button" class="g-icon-btn" id="gFilterOpen" aria-label="Filters">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M4 6h16M4 12h10M4 18h6"/></svg>
            </button>
            <a href="{{ route('cart.view') }}" class="g-icon-btn" aria-label="Cart">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
            </a>
            @auth
                <div class="dropdown">
                    <button class="g-icon-btn" type="button" data-bs-toggle="dropdown" aria-label="Account">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                        @if(Auth::user()->is_admin ?? Auth::user()->isAdmin())
                            <li><a class="dropdown-item" href="{{ route('admin.products.index') }}">Admin Panel</a></li>
                        @endif
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item w-100 text-start">Log Out</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a href="{{ route('login') }}" class="g-btn-ghost">Login</a>
                <a href="{{ route('register') }}" class="g-btn-accent">Register</a>
            @endauth
        </div>
    </header>

    <!-- mobile menu -->
    <div class="g-mobile-overlay" id="gMobileOverlay"></div>
    <div class="g-mobile-menu" id="gMobileMenu">
        <div class="g-mobile-menu-logo">Grow<span>zio</span></div>
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('home') }}">Products</a>
        <div class="g-filter-sect" style="padding:0.75rem 1.25rem; font-size:11px; color:var(--g-accent);">Menu</div>
    </div>

    <!-- filter drawer (static) -->
    <div class="g-filter-overlay" id="gFilterOverlay"></div>
    <div class="g-filter-drawer" id="gFilterDrawer">
        <div class="g-filter-header">Filters</div>
        <div class="g-filter-body">
            <p class="g-section-sub" style="font-size:13px; color:var(--g-text-muted);">No filters available on this page.</p>
        </div>
    </div>

    <!-- back to top -->
    <button id="g-back-top" aria-label="Back to top">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 15l-6-6-6 6"/></svg>
    </button>

    <!-- MAIN CONTENT (CART) -->
    <main class="g-main">
        <div class="g-section">
            <div class="g-container" style="max-width: 1100px;">
                <div class="g-section-head text-start mb-4">
                    <div class="g-section-eyebrow">// Your cart</div>
                    <h1 class="g-section-title" style="font-size: 1.8rem;">Shopping Cart</h1>
                </div>

                @guest
                <div class="guest-notice">
                    <i class="fas fa-info-circle"></i>
                    <div class="guest-notice-content">
                        <h3 style="font-size: 0.9rem; font-weight: 600;">Guest User</h3>
                        <p>You're viewing your cart as a guest. 
                            <a href="{{ route('login') }}">Login</a> or 
                            <a href="{{ route('register') }}">register</a> 
                            to save your cart and proceed to checkout.</p>
                    </div>
                </div>
                @endguest

                <div class="cart-card" id="cart-content">
                    <div class="p-4">
                        @if (count($items))
                            @foreach ($items as $item)
                                <div class="cart-item">
                                    <div class="cart-item-image">
                                        @if ($item['product']->image_path)
                                            <img src="{{ asset($item['product']->image_path) }}" alt="{{ $item['product']->name }}">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center h-100">
                                                <i class="fas fa-image" style="color: var(--g-text-muted);"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="cart-item-details">
                                        <div class="cart-item-name">
                                            <a href="{{ route('products.show', $item['product']) }}">{{ $item['product']->name }}</a>
                                        </div>
                                        <div class="cart-item-price">₹{{ number_format($item['product']->price, 2) }} each</div>
                                        <form method="POST" action="{{ route('cart.update', $item['product']) }}" class="d-flex align-items-center gap-2 flex-wrap">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="quantity-input">
                                            <button type="submit" class="btn-update">Update</button>
                                        </form>
                                    </div>
                                    <div class="cart-item-actions d-flex flex-column align-items-end gap-2">
                                        <div class="cart-item-subtotal">₹{{ number_format($item['subtotal'], 2) }}</div>
                                        <form method="POST" action="{{ route('cart.remove', $item['product']) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-remove"><i class="fas fa-trash-alt me-1"></i>Remove</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach

                            @auth
                            @if($loyaltyPointsAvailable > 0)
                            <div class="cart-loyalty">
                                <h4 class="mb-2" style="font-size: 0.9rem; font-weight: 700;">Use loyalty points</h4>
                                <p class="mb-3" style="font-size: 0.75rem; color: var(--g-text-muted);">10 points = ₹1 discount. You have <strong>{{ $loyaltyPointsAvailable }}</strong> points.</p>
                                <form method="POST" action="{{ route('cart.loyalty') }}" class="d-flex flex-wrap align-items-end gap-3 mb-3">
                                    @csrf
                                    <div>
                                        <label class="form-label mb-0" style="font-size: 0.7rem;">Points to use</label>
                                        <input type="number" name="loyalty_points_to_use" class="quantity-input" value="{{ $loyaltyPointsToUse }}" min="0" max="{{ $loyaltyPointsAvailable }}" step="10" style="width: 100px;">
                                    </div>
                                    <button type="submit" class="btn-update">Apply</button>
                                </form>
                                @if($loyaltyPointsToUse > 0)
                                    <p class="mb-0 small" style="color: var(--g-text-muted);">Discount: ₹{{ number_format($loyaltyDiscountAmount, 2) }} · Remaining points after checkout: <strong>{{ $remainingPoints }}</strong></p>
                                @endif
                            </div>
                            @endif
                            @endauth

                            <div class="cart-summary">
                                <div>
                                    <div class="d-flex justify-content-between mb-1" style="color: var(--g-text-muted);">
                                        <span>Subtotal</span>
                                        <span>₹{{ number_format($subtotal, 2) }}</span>
                                    </div>
                                    @auth
                                    @if($loyaltyDiscountAmount > 0)
                                    <div class="d-flex justify-content-between mb-2" style="color: var(--g-text-muted);">
                                        <span>Loyalty discount</span>
                                        <span>-₹{{ number_format($loyaltyDiscountAmount, 2) }}</span>
                                    </div>
                                    @endif
                                    @endauth
                                    <div class="cart-total">Total: ₹{{ number_format($total, 2) }}</div>
                                </div>
                                <div class="cart-actions d-flex gap-2">
                                    <form method="POST" action="{{ route('cart.clear') }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-clear">Clear Cart</button>
                                    </form>
                                    @auth
                                        <a href="{{ route('checkout.form') }}" class="btn-checkout"><i class="fas fa-arrow-right"></i> Checkout</a>
                                    @else
                                        <a href="{{ route('checkout.login-required') }}" class="btn-checkout"><i class="fas fa-arrow-right"></i> Proceed to Checkout</a>
                                    @endauth
                                </div>
                            </div>
                        @else
                            <div class="empty-cart">
                                <i class="fas fa-shopping-cart"></i>
                                <h3>Your cart is empty</h3>
                                <p>Looks like you haven't added any products yet.</p>
                                <a href="{{ route('home') }}" class="btn-checkout" style="display: inline-flex;">Continue Shopping</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

    @if (count($items))
    <!-- sticky bottom (mobile only) -->
    <div class="g-sticky-bottom-cart">
        <button type="button" class="sticky-view-cart" onclick="document.getElementById('cart-content').scrollIntoView({ behavior: 'smooth', block: 'start' })">
            <i class="fas fa-shopping-cart me-1"></i> View cart
        </button>
        <span class="sticky-total">₹{{ number_format($total, 2) }}</span>
        @auth
            <a href="{{ route('checkout.form') }}" class="sticky-checkout">Checkout</a>
        @else
            <a href="{{ route('checkout.login-required') }}" class="sticky-checkout">Proceed</a>
        @endauth
    </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function() {
            // header scroll class
            var header = document.getElementById('gHeader');
            if (header) {
                window.addEventListener('scroll', function() {
                    header.classList.toggle('scrolled', window.scrollY > 10);
                }, { passive: true });
            }
            // back to top
            var backTop = document.getElementById('g-back-top');
            if (backTop) {
                window.addEventListener('scroll', function() {
                    backTop.classList.toggle('visible', window.scrollY > 320);
                });
                backTop.addEventListener('click', function() {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            }
            // mobile menu
            var hamburger = document.getElementById('gHamburger');
            var mobileMenu = document.getElementById('gMobileMenu');
            var mobileOvly = document.getElementById('gMobileOverlay');
            function openMobile() { mobileMenu.classList.add('open'); mobileOvly.classList.add('open'); document.body.style.overflow = 'hidden'; }
            function closeMobile() { mobileMenu.classList.remove('open'); mobileOvly.classList.remove('open'); document.body.style.overflow = ''; }
            if (hamburger) hamburger.addEventListener('click', openMobile);
            if (mobileOvly) mobileOvly.addEventListener('click', closeMobile);
            // filter drawer
            var filterOpen = document.getElementById('gFilterOpen');
            var filterDrawer = document.getElementById('gFilterDrawer');
            var filterOvly = document.getElementById('gFilterOverlay');
            if (filterOpen && filterDrawer && filterOvly) {
                filterOpen.addEventListener('click', function() {
                    filterDrawer.classList.add('open');
                    filterOvly.classList.add('open');
                    document.body.style.overflow = 'hidden';
                });
                filterOvly.addEventListener('click', function() {
                    filterDrawer.classList.remove('open');
                    filterOvly.classList.remove('open');
                    document.body.style.overflow = '';
                });
            }
        })();
    </script>
</body>
</html>