<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Growzio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* =============================================
           GROWZIO — DESIGN SYSTEM (identical to index)
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

        h1, h2, h3, h4, h5, h6 { font-family: var(--font-head); }
        .mono { font-family: var(--font-mono); }

        /* Animations */
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

        /* Reveal on scroll */
        .g-reveal {
            opacity: 0;
            transform: translateY(32px);
            transition: opacity 0.65s var(--g-ease), transform 0.65s var(--g-ease);
        }
        .g-reveal.g-revealed {
            opacity: 1;
            transform: translateY(0);
        }

        /* Header (exact copy from index) */
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
        @media (max-width: 767.98px) { .g-logo { display: none; } }

        .g-nav-desktop { display: none; }
        @media (min-width: 768px) {
            .g-nav-desktop { display: flex; align-items: center; gap: 0.1rem; }
            .g-nav-desktop a {
                padding: 0.45rem 0.85rem;
                font-size: 13.5px;
                font-weight: 500;
                color: var(--g-text-muted);
                text-decoration: none;
                border-radius: var(--g-radius);
                transition: color 0.2s, background 0.2s;
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

        /* Mobile menu */
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
        .g-mobile-menu a,
        .g-mobile-menu .g-filter-sect {
            display: block;
            padding: 0.75rem 1.25rem;
            font-size: 14px;
            font-weight: 500;
            color: var(--g-text-muted);
            text-decoration: none;
            border-bottom: 1px solid var(--g-border);
        }
        .g-mobile-menu a:hover {
            color: var(--g-accent);
            background: rgba(255,211,105,0.05);
            padding-left: 1.6rem;
        }

        /* Main container */
        .g-main {
            padding: 1.5rem 1rem 3rem;
            max-width: 1320px;
            margin: 0 auto;
        }
        @media (min-width: 992px) {
            .g-main { padding: 2rem 2rem 4rem; }
        }

        /* Back link */
        .g-back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 13px;
            font-family: var(--font-mono);
            color: var(--g-text-muted);
            text-decoration: none;
            margin-bottom: 1.5rem;
            transition: color 0.2s;
        }
        .g-back-link:hover { color: var(--g-accent); }

        /* Product detail card */
        .g-product-detail {
            background: var(--g-card-bg);
            border: 1px solid var(--g-border);
            border-radius: var(--g-radius-lg);
            overflow: hidden;
            margin-bottom: 2rem;
        }
        .g-product-image-wrap {
            background: var(--g-bg2);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            min-height: 320px;
        }
        @media (min-width: 992px) {
            .g-product-image-wrap { min-height: 480px; border-right: 1px solid var(--g-border); }
        }
        .g-product-image {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            transition: opacity 0.3s;
        }
        .g-product-info { padding: 1.5rem; }
        @media (min-width: 992px) { .g-product-info { padding: 2rem; } }

        .g-product-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }
        .g-product-badge {
            font-size: 11px;
            font-family: var(--font-mono);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0.25rem 0.75rem;
            background: rgba(255,211,105,0.1);
            border: 1px solid var(--g-border);
            color: var(--g-accent);
            border-radius: var(--g-radius);
        }

        /* Product title: use DM Sans for clean numbers */
        .g-product-title {
            font-family: var(--font-body);
            font-size: 1.75rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            margin-bottom: 0.5rem;
            color: var(--g-light);
        }
        @media (min-width: 768px) { .g-product-title { font-size: 2rem; } }
        .g-product-subtitle {
            font-size: 14px;
            color: var(--g-text-muted);
            margin-bottom: 1.5rem;
        }

        .g-product-details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .g-product-detail-item {
            background: rgba(34,40,49,0.6);
            border: 1px solid var(--g-border);
            border-radius: var(--g-radius);
            padding: 0.75rem 1rem;
        }
        .g-product-detail-label {
            font-size: 10px;
            font-family: var(--font-mono);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--g-text-muted);
            margin-bottom: 0.25rem;
        }
        .g-product-detail-value {
            font-size: 14px;
            font-weight: 500;
            color: var(--g-light);
        }

        .g-product-price {
            background: rgba(255,211,105,0.08);
            border: 1px solid var(--g-border);
            border-radius: var(--g-radius);
            padding: 0.5rem 1rem;
            display: inline-block;
            margin-bottom: 1.5rem;
        }
        .g-product-price-label {
            font-size: 10px;
            font-family: var(--font-mono);
            color: var(--g-text-muted);
        }
        .g-product-price-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--g-accent);
        }

        .g-cart-form {
            border: 1px solid var(--g-border);
            border-radius: var(--g-radius);
            padding: 1.25rem;
            margin-bottom: 1rem;
        }
        .g-qty-row {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        .g-qty-row label {
            font-size: 13px;
            color: var(--g-text-muted);
        }
        .g-qty-input {
            width: 80px;
            padding: 0.5rem;
            background: var(--g-bg);
            border: 1px solid var(--g-border);
            color: var(--g-text);
            border-radius: var(--g-radius);
            font-family: var(--font-mono);
        }
        .g-add-to-cart-btn {
            width: 100%;
            background: var(--g-accent);
            color: var(--g-bg);
            border: none;
            padding: 0.75rem;
            font-weight: 600;
            font-size: 14px;
            border-radius: var(--g-radius);
            transition: transform 0.2s, background 0.2s;
            cursor: pointer;
        }
        .g-add-to-cart-btn:hover {
            background: #e8bc52;
            transform: translateY(-1px);
        }
        .g-add-to-cart-btn:disabled { opacity: 0.6; cursor: not-allowed; }

        .g-product-description {
            border: 1px solid var(--g-border);
            border-radius: var(--g-radius);
            padding: 1.25rem;
        }
        .g-product-description-title {
            font-size: 11px;
            font-family: var(--font-mono);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--g-accent);
            margin-bottom: 0.75rem;
        }
        .g-product-description-text {
            font-size: 14px;
            line-height: 1.6;
            white-space: pre-wrap;
        }
        @media (max-width: 767px) {
            .g-product-description-text.is-clamped {
                max-height: 96px;
                overflow: hidden;
            }
        }
        .g-desc-toggle {
            background: none;
            border: none;
            color: var(--g-accent);
            font-size: 13px;
            font-family: var(--font-mono);
            margin-top: 0.5rem;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            cursor: pointer;
        }

        /* You May Also Like — improved for mobile (smaller cards, better alignment) */
        .g-related-section {
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid var(--g-border);
        }
        .g-section-eyebrow {
            font-family: var(--font-mono);
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: var(--g-accent);
            text-align: center;
            margin-bottom: 0.5rem;
        }
        .g-section-title {
            font-family: var(--font-head);
            font-size: clamp(1.5rem, 3vw, 2rem);
            font-weight: 700;
            letter-spacing: -0.02em;
            text-align: center;
            color: var(--g-light);
            margin-bottom: 2rem;
        }
        .g-related-carousel-wrap {
            position: relative;
            padding: 0 40px;
        }
        .g-related-track {
            display: flex;
            gap: 1rem;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            padding: 0.5rem 0;
        }
        .g-related-track::-webkit-scrollbar { display: none; }
        .g-related-card {
            flex: 0 0 200px;
            scroll-snap-align: start;
            background: var(--g-card-bg);
            border: 1px solid var(--g-border);
            border-radius: var(--g-radius-lg);
            overflow: hidden;
            text-decoration: none;
            transition: border-color 0.2s, transform 0.2s var(--g-ease-spring);
        }
        .g-related-card:hover {
            border-color: var(--g-border-hover);
            transform: translateY(-4px);
        }
        .g-related-card-image {
            aspect-ratio: 1 / 1;
            background: var(--g-bg2);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .g-related-card-image img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            transition: transform 0.3s ease;
        }
        .g-related-card:hover .g-related-card-image img {
            transform: scale(1.05);
        }
        .g-related-card-body {
            padding: 0.75rem;
        }
        .g-related-card-title {
            font-size: 12px;
            font-weight: 500;
            color: var(--g-light);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: 0.25rem;
            line-height: 1.4;
        }
        .g-related-card-price {
            font-size: 12px;
            font-family: var(--font-mono);
            color: var(--g-accent);
        }
        .g-carousel-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 36px;
            height: 36px;
            background: var(--g-bg2);
            border: 1px solid var(--g-border);
            border-radius: var(--g-radius);
            color: var(--g-text-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            z-index: 2;
        }
        .g-carousel-btn:hover {
            border-color: var(--g-border-hover);
            color: var(--g-accent);
            background: rgba(255,211,105,0.08);
        }
        .g-carousel-btn.prev { left: 0; }
        .g-carousel-btn.next { right: 0; }

        /* Mobile adjustments for related section */
        @media (max-width: 768px) {
            .g-related-carousel-wrap { padding: 0 20px; }
            .g-related-card { flex: 0 0 160px; }
            .g-related-card-body { padding: 0.6rem; }
            .g-related-card-title { font-size: 11px; }
            .g-related-card-price { font-size: 11px; }
            .g-carousel-btn { width: 30px; height: 30px; }
        }

        /* Toast */
        .g-toast {
            position: fixed;
            bottom: 1.5rem;
            right: 1.5rem;
            z-index: 9999;
            padding: 0.75rem 1.25rem;
            background: var(--g-bg2);
            border: 1px solid var(--g-border-hover);
            color: var(--g-light);
            font-size: 13.5px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            border-radius: var(--g-radius-lg);
            box-shadow: 0 8px 32px rgba(0,0,0,0.4);
            animation: toastSlide 0.35s var(--g-ease-spring);
        }
        .g-toast-icon { color: var(--g-accent); }
        .g-spinner {
            width: 18px; height: 18px;
            border: 2px solid rgba(255,211,105,0.2);
            border-top-color: var(--g-accent);
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            display: inline-block;
        }
    </style>
</head>
<body>

    <!-- ██ HEADER (exact copy from index) ██ -->
    <header class="g-header" id="gHeader">
        <div class="g-header-left">
            <button type="button" class="g-hamburger" id="gHamburger" aria-label="Menu">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M3 12h18M3 6h18M3 18h18"/></svg>
            </button>
            <a href="{{ route('home') }}" class="g-logo">Grow<span>zio</span></a>
            <nav class="g-nav-desktop">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                <a href="{{ route('home') }}" class="active">Products</a>
            </nav>
        </div>
        <div class="g-header-right">
            <a href="{{ route('cart.view') }}" class="g-icon-btn g-cart-link" aria-label="Cart">
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
                        @if(Auth::user()->isAdmin())
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin Panel</a></li>
                        @endif
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">@csrf
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

    <!-- Mobile menu overlay -->
    <div class="g-mobile-overlay" id="gMobileOverlay"></div>
    <div class="g-mobile-menu" id="gMobileMenu">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('home') }}">Products</a>
        <div class="g-filter-sect">Categories</div>
        <!-- dynamic categories would go here if needed, but keeping as index -->
    </div>

    <!-- ██ MAIN CONTENT ██ -->
    <main class="g-main">
        <a href="{{ route('home') }}" class="g-back-link">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Back to Products
        </a>

        @include('partials.toast')

        <div class="g-product-detail g-reveal">
            <div class="row g-0">
                <div class="col-lg-5">
                    <div class="g-product-image-wrap">
                        @if ($product->image_path)
                            <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" class="g-product-image" id="productImage" loading="lazy">
                        @else
                            <div style="color: var(--g-text-muted); text-align: center;">
                                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                                <p class="mt-2">No image available</p>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="g-product-info">
                        <div class="g-product-badges">
                            @if($product->category)
                                <span class="g-product-badge">{{ $product->category->name }}</span>
                            @endif
                            <span class="g-product-badge">{{ $product->brand_name ?? '—' }}</span>
                        </div>
                        <h1 class="g-product-title">{{ $product->name }}</h1>
                        @if($product->product_name_hi)
                            <p class="g-product-subtitle">{{ $product->product_name_hi }}</p>
                        @endif

                        <div class="g-product-details-grid">
                            <div class="g-product-detail-item">
                                <div class="g-product-detail-label">Company Part Number</div>
                                <div class="g-product-detail-value">{{ $product->company_part_number ?? '—' }}</div>
                            </div>
                            @if($product->company_part_number_substitute)
                            <div class="g-product-detail-item">
                                <div class="g-product-detail-label">Alternative Part No.</div>
                                <div class="g-product-detail-value">{{ $product->company_part_number_substitute }}</div>
                            </div>
                            @endif
                            @if($product->local_part_number)
                            <div class="g-product-detail-item">
                                <div class="g-product-detail-label">Local Part Number</div>
                                <div class="g-product-detail-value">{{ $product->local_part_number }}</div>
                            </div>
                            @endif
                        </div>

                        <div class="g-product-price">
                            <div class="g-product-price-label">MRP</div>
                            <div class="g-product-price-value">₹{{ number_format((float) $product->price, 2) }}</div>
                        </div>

                        <div class="g-cart-form">
                            <form method="POST" action="{{ route('cart.add', $product) }}" id="addToCartForm">
                                @csrf
                                <div class="g-qty-row">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" name="quantity" id="quantity" value="1" min="1" class="g-qty-input">
                                </div>
                                <button type="submit" class="g-add-to-cart-btn" id="addToCartBtn">Add to Cart</button>
                            </form>
                            @guest
                                <p class="mt-2 mb-0 small" style="color: var(--g-text-muted);">Guests can add items to cart.</p>
                            @endguest
                        </div>

                        @if($product->description)
                        <div class="g-product-description" id="descSection">
                            <div class="g-product-description-title">Description</div>
                            <div class="g-product-description-text is-clamped" id="descText">{{ $product->description }}</div>
                            <button type="button" class="g-desc-toggle d-md-none" id="descToggle">
                                <span id="descToggleLabel">Read more</span>
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m6 9 6 6 6-6"/></svg>
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if($youMayAlsoLike->isNotEmpty())
        <section class="g-related-section g-reveal">
            <div class="g-section-eyebrow">// You may also like</div>
            <h2 class="g-section-title">Similar products</h2>
            <div class="g-related-carousel-wrap">
                <button class="g-carousel-btn prev" id="relatedPrev" aria-label="Previous">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M15 18l-6-6 6-6"/></svg>
                </button>
                <button class="g-carousel-btn next" id="relatedNext" aria-label="Next">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="m9 18 6-6-6-6"/></svg>
                </button>
                <div class="g-related-track" id="relatedTrack">
                    @foreach($youMayAlsoLike as $related)
                    <a href="{{ route('products.show', $related) }}" class="g-related-card">
                        <div class="g-related-card-image">
                            @if ($related->image_path)
                                <img src="{{ asset($related->image_path) }}" alt="{{ $related->name }}" loading="lazy">
                            @else
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/></svg>
                            @endif
                        </div>
                        <div class="g-related-card-body">
                            <div class="g-related-card-title">{{ $related->name }}</div>
                            <div class="g-related-card-price">₹{{ number_format((float) $related->price, 2) }}</div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </section>
        @endif
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function() {
            // Sticky header
            const header = document.getElementById('gHeader');
            if (header) {
                window.addEventListener('scroll', () => header.classList.toggle('scrolled', window.scrollY > 10), { passive: true });
            }

            // Mobile menu
            const hamburger = document.getElementById('gHamburger');
            const mobileMenu = document.getElementById('gMobileMenu');
            const mobileOverlay = document.getElementById('gMobileOverlay');
            function openMobile() { mobileMenu.classList.add('open'); mobileOverlay.classList.add('open'); document.body.style.overflow = 'hidden'; }
            function closeMobile() { mobileMenu.classList.remove('open'); mobileOverlay.classList.remove('open'); document.body.style.overflow = ''; }
            if (hamburger) hamburger.addEventListener('click', openMobile);
            if (mobileOverlay) mobileOverlay.addEventListener('click', closeMobile);

            // Product image fade-in
            const prodImg = document.getElementById('productImage');
            if (prodImg) {
                if (prodImg.complete) prodImg.style.opacity = '1';
                else prodImg.addEventListener('load', () => prodImg.style.opacity = '1');
            }

            // Description toggle (mobile)
            const descSection = document.getElementById('descSection');
            const descToggle = document.getElementById('descToggle');
            const descLabel = document.getElementById('descToggleLabel');
            const descText = document.getElementById('descText');
            if (descSection && descToggle && descText) {
                descToggle.addEventListener('click', () => {
                    const isExpanded = descSection.classList.toggle('is-expanded');
                    descText.classList.toggle('is-clamped', !isExpanded);
                    descLabel.textContent = isExpanded ? 'Read less' : 'Read more';
                });
            }

            // Add to cart AJAX
            const cartForm = document.getElementById('addToCartForm');
            const cartBtn = document.getElementById('addToCartBtn');
            if (cartForm && cartBtn) {
                cartForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const originalHtml = cartBtn.innerHTML;
                    cartBtn.innerHTML = '<span class="g-spinner"></span>';
                    cartBtn.disabled = true;
                    fetch(cartForm.action, {
                        method: 'POST',
                        body: new FormData(cartForm),
                        credentials: 'same-origin',
                        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                    })
                    .then(res => {
                        if (!res.ok) return res.json().then(err => { throw new Error(err.message || 'Request failed'); });
                        return res.json();
                    })
                    .then(data => {
                        if (!data.success) throw new Error(data.message || 'Could not add to cart');
                        showToast(data.message || 'Added to cart', false);
                        cartBtn.innerHTML = originalHtml;
                        cartBtn.disabled = false;
                    })
                    .catch(err => {
                        showToast(err.message || 'Could not add to cart', true);
                        cartBtn.innerHTML = originalHtml;
                        cartBtn.disabled = false;
                    });
                });
            }

            // Toast helper
            function showToast(message, isError) {
                const existing = document.getElementById('g-toast');
                if (existing) existing.remove();
                const toast = document.createElement('div');
                toast.id = 'g-toast';
                toast.className = 'g-toast';
                const icon = isError ? '⚠️' : '✓';
                toast.innerHTML = `<span class="g-toast-icon">${icon}</span> ${escapeHtml(message)}`;
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 2800);
            }
            function escapeHtml(str) {
                return str.replace(/[&<>]/g, function(m) {
                    if (m === '&') return '&amp;';
                    if (m === '<') return '&lt;';
                    if (m === '>') return '&gt;';
                    return m;
                });
            }

            // Related products carousel
            const track = document.getElementById('relatedTrack');
            const prevBtn = document.getElementById('relatedPrev');
            const nextBtn = document.getElementById('relatedNext');
            if (track && prevBtn && nextBtn) {
                const scrollAmount = () => {
                    const card = track.querySelector('.g-related-card');
                    const cardWidth = card ? card.offsetWidth : 160;
                    const gap = 16;
                    return cardWidth + gap;
                };
                prevBtn.addEventListener('click', () => track.scrollBy({ left: -scrollAmount(), behavior: 'smooth' }));
                nextBtn.addEventListener('click', () => track.scrollBy({ left: scrollAmount(), behavior: 'smooth' }));
            }

            // Reveal on scroll
            const reveals = document.querySelectorAll('.g-reveal');
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('g-revealed');
                        observer.unobserve(entry.target);
                    }
                });
            }, { rootMargin: '0px 0px -50px 0px', threshold: 0.1 });
            reveals.forEach(el => observer.observe(el));
        })();
    </script>
</body>
</html>