{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Premium Store</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        :root {
            --unity-bg: #FFFFFF;
            --unity-bg-secondary: #F7F7F7;
            --unity-text: #121212;
            --unity-text-secondary: #707070;
            --unity-desc: #505050;
            --unity-meta-category: #5c5c5c;
            --unity-meta-partno: #888888;
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
            overflow-x: hidden;
        }

        /* ----- Header (sticky, minimal) ----- */
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

        .unity-header-left {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        .unity-logo {
            font-size: 1.125rem;
            font-weight: 600;
            letter-spacing: -0.02em;
            color: var(--unity-text);
            text-decoration: none;
        }
        .unity-nav-desktop {
            display: none;
        }
        @media (min-width: 768px) {
            .unity-nav-desktop { display: flex; align-items: center; gap: 0.25rem; }
            .unity-nav-desktop a {
                padding: 0.5rem 0.75rem;
                font-size: 14px;
                color: var(--unity-text-secondary);
                text-decoration: none;
                transition: color 0.2s var(--unity-ease);
            }
            .unity-nav-desktop a:hover, .unity-nav-desktop a.active { color: var(--unity-text); }
        }

        .unity-header-right {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .unity-icon-btn {
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--unity-text);
            border: none;
            background: transparent;
            cursor: pointer;
            transition: background 0.2s var(--unity-ease), color 0.2s var(--unity-ease);
        }
        .unity-icon-btn:hover { background: var(--unity-bg-secondary); }
        .unity-icon-btn svg { stroke-width: 2; }
        .unity-cart-badge {
            position: absolute;
            top: 4px;
            right: 4px;
            min-width: 16px;
            height: 16px;
            padding: 0 4px;
            font-size: 10px;
            font-weight: 600;
            color: #fff;
            background: var(--unity-text);
            border-radius: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .unity-cart-wrap { position: relative; }

        /* Hamburger: visible on mobile only */
        .unity-hamburger {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border: none;
            background: transparent;
            color: var(--unity-text);
            cursor: pointer;
        }
        @media (min-width: 768px) { .unity-hamburger { display: none; } }

        /* ----- Mobile menu (slide from left) ----- */
        .unity-mobile-menu {
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            max-width: 85vw;
            height: 100vh;
            background: var(--unity-bg);
            border-right: 1px solid var(--unity-border);
            z-index: 1060;
            transform: translateX(-100%);
            transition: transform 0.3s var(--unity-ease);
            overflow-y: auto;
            padding: 1rem 0;
        }
        .unity-mobile-menu.open { transform: translateX(0); }
        .unity-mobile-menu-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.3);
            z-index: 1055;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s var(--unity-ease), visibility 0.3s;
        }
        .unity-mobile-menu-overlay.open { opacity: 1; visibility: visible; }
        .unity-mobile-menu a, .unity-mobile-menu .unity-filter-section { display: block; padding: 0.75rem 1.25rem; font-size: 14px; color: var(--unity-text); text-decoration: none; border-bottom: 1px solid var(--unity-border); }
        .unity-mobile-menu a:hover { background: var(--unity-bg-secondary); }

        /* ----- Search overlay (full-width) ----- */
        .unity-search-overlay {
            position: fixed;
            inset: 0;
            background: var(--unity-bg);
            z-index: 1100;
            display: flex;
            flex-direction: column;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.25s var(--unity-ease), visibility 0.25s;
        }
        .unity-search-overlay.open { opacity: 1; visibility: visible; }
        .unity-search-overlay-header {
            display: flex;
            align-items: center;
            border-bottom: 1px solid var(--unity-border);
            padding: 1rem 1.5rem;
        }
        .unity-search-overlay-input-wrap {
            flex: 1;
            margin: 0 1rem;
        }
        .unity-search-overlay-input {
            width: 100%;
            padding: 0.875rem 1rem;
            font-size: 1.125rem;
            font-family: inherit;
            border: 1px solid var(--unity-border);
            border-radius: 0;
            outline: none;
            transition: border-color 0.2s var(--unity-ease);
        }
        .unity-search-overlay-input:focus { border-color: var(--unity-text); }
        .unity-search-overlay-close {
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            background: transparent;
            color: var(--unity-text);
            cursor: pointer;
        }
        .unity-search-suggestions { flex: 1; overflow-y: auto; padding: 1rem; max-width: 680px; margin: 0 auto; width: 100%; }
        .unity-search-suggestion-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--unity-border);
            text-decoration: none;
            color: var(--unity-text);
            transition: background 0.2s var(--unity-ease);
        }
        .unity-search-suggestion-item:hover { background: var(--unity-bg-secondary); }
        .unity-search-suggestion-item img { width: 48px; height: 48px; object-fit: cover; }
        .unity-search-suggestion-item .price { font-size: 14px; color: var(--unity-text-secondary); }

        /* ----- Filter drawer (slide-out) ----- */
        .unity-filter-drawer {
            position: fixed;
            top: 0;
            right: 0;
            width: 320px;
            max-width: 90vw;
            height: 100vh;
            background: var(--unity-bg);
            border-left: 1px solid var(--unity-border);
            z-index: 1060;
            transform: translateX(100%);
            transition: transform 0.3s var(--unity-ease);
            overflow-y: auto;
        }
        .unity-filter-drawer.open { transform: translateX(0); }
        .unity-filter-drawer-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.3);
            z-index: 1055;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s var(--unity-ease), visibility 0.3s;
        }
        .unity-filter-drawer-overlay.open { opacity: 1; visibility: visible; }
        .unity-filter-drawer-header { padding: 1rem 1.25rem; border-bottom: 1px solid var(--unity-border); font-weight: 600; letter-spacing: -0.02em; }
        .unity-filter-drawer-body { padding: 1rem; }

        /* ----- Cart drawer (side-cart) ----- */
        .unity-cart-drawer {
            position: fixed;
            top: 0;
            right: 0;
            width: 380px;
            max-width: 100vw;
            height: 100vh;
            background: var(--unity-bg);
            border-left: 1px solid var(--unity-border);
            z-index: 1060;
            display: flex;
            flex-direction: column;
            transform: translateX(100%);
            transition: transform 0.3s var(--unity-ease);
        }
        .unity-cart-drawer.open { transform: translateX(0); }
        .unity-cart-drawer-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.3);
            z-index: 1055;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s var(--unity-ease), visibility 0.3s;
        }
        .unity-cart-drawer-overlay.open { opacity: 1; visibility: visible; }
        .unity-cart-drawer-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--unity-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-weight: 600;
            letter-spacing: -0.02em;
        }
        .unity-cart-drawer-close { width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border: none; background: transparent; cursor: pointer; }
        .unity-cart-drawer-body { flex: 1; overflow-y: auto; padding: 1rem; }
        .unity-cart-drawer-item {
            display: flex;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid var(--unity-border);
        }
        .unity-cart-drawer-item img { width: 64px; height: 80px; object-fit: cover; }
        .unity-cart-drawer-item-info { flex: 1; min-width: 0; }
        .unity-cart-drawer-item-name { font-size: 14px; color: var(--unity-text); margin-bottom: 0.25rem; }
        .unity-cart-drawer-item-meta { font-size: 14px; color: var(--unity-text-secondary); }
        .unity-cart-drawer-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid var(--unity-border);
        }
        .unity-cart-drawer-subtotal { font-weight: 600; letter-spacing: -0.02em; margin-bottom: 1rem; }
        .unity-cart-drawer-empty { padding: 2rem; text-align: center; color: var(--unity-text-secondary); font-size: 14px; }
        .unity-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.25rem;
            font-size: 14px;
            font-family: inherit;
            font-weight: 500;
            border-radius: 0;
            cursor: pointer;
            transition: background 0.2s var(--unity-ease), color 0.2s var(--unity-ease), border-color 0.2s var(--unity-ease);
            text-decoration: none;
            border: 1px solid var(--unity-border);
            background: var(--unity-bg);
            color: var(--unity-text);
        }
        .unity-btn-primary { background: var(--unity-text); color: var(--unity-bg); border-color: var(--unity-text); }
        .unity-btn-primary:hover { opacity: 0.9; }
        .unity-cart-drawer-actions { display: flex; flex-direction: column; gap: 0.5rem; }

        /* ----- Main content padding ----- */
        .unity-main { padding-top: 0; }
        .unity-section { padding: 40px 1rem; }
        @media (min-width: 992px) { .unity-section { padding: 80px 2rem; } }
        @media (min-width: 1200px) { .unity-section { padding: 100px 2rem; } }

        .unity-container { max-width: 1280px; margin: 0 auto; }

        /* ----- Categories (Unity style) ----- */
        .unity-categories { background: var(--unity-bg-secondary); }
        .unity-category-dropdown {
            background: var(--unity-bg);
            border: 1px solid var(--unity-border);
            border-radius: 0;
            max-width: 960px;
            margin: 0 auto;
        }
        .unity-category-dropdown summary {
            list-style: none;
            cursor: pointer;
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-weight: 500;
            letter-spacing: -0.02em;
        }
        .unity-category-dropdown summary::-webkit-details-marker { display: none; }
        .unity-category-dropdown-body { border-top: 1px solid var(--unity-border); }
        .unity-category-list { list-style: none; margin: 0; padding: 0; }
        .unity-category-item { border-bottom: 1px solid var(--unity-border); }
        .unity-category-item:last-child { border-bottom: none; }
        .unity-category-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 0.75rem 1.25rem;
        }
        .unity-category-name { font-size: 14px; color: var(--unity-text); }
        .unity-category-link {
            font-size: 14px;
            color: var(--unity-text-secondary);
            text-decoration: none;
            transition: color 0.2s var(--unity-ease);
        }
        .unity-category-link:hover { color: var(--unity-text); }
        .unity-category-children { list-style: none; margin: 0; padding-left: 1.5rem; border-left: 1px solid var(--unity-border); margin-left: 1.25rem; }
        .unity-category-children.hidden { display: none; }

        /* ----- Product grid & cards ----- */
        .unity-products-section { background: var(--unity-bg); }
        .unity-section-title {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        .unity-section-title h2 {
            font-size: 1.75rem;
            font-weight: 600;
            letter-spacing: -0.02em;
            color: var(--unity-text);
            margin-bottom: 0.5rem;
        }
        .unity-section-subtitle { font-size: 14px; color: var(--unity-text-secondary); }
        .unity-product-col { margin-bottom: 1.5rem; }
        .unity-product-card {
            position: relative;
            background: var(--unity-bg);
            border: 1px solid var(--unity-border);
            border-radius: 0;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: border-color 0.2s var(--unity-ease), box-shadow 0.2s var(--unity-ease);
        }
        .unity-product-card:hover { border-color: var(--unity-text-secondary); }
        .unity-product-link { text-decoration: none; color: inherit; display: block; flex: 1; }
        .unity-product-image {
            aspect-ratio: 4/5;
            background: var(--unity-bg-secondary);
            overflow: hidden;
        }
        .unity-product-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            transition: transform 0.4s var(--unity-ease);
        }
        .unity-product-card:hover .unity-product-image img { transform: scale(1.05); }
        .unity-product-image-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--unity-text-secondary);
        }
        .unity-product-image-placeholder .unity-icon { width: 48px; height: 48px; }
        .unity-product-details {
            padding: 1rem 1rem 0;
            display: flex;
            flex-wrap: wrap;
            align-items: baseline;
            gap: 0.5rem;
        }
        .unity-product-name {
            font-size: 14px;
            font-weight: 500;
            color: var(--unity-desc);
            flex: 1;
            min-width: 0;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .unity-product-price {
            font-size: 14px;
            font-weight: 400;
            color: var(--unity-text-secondary);
        }
        .unity-product-meta {
            display: none;
            font-size: 12px;
            color: var(--unity-meta-partno);
            width: 100%;
        }
        .unity-product-meta .unity-product-category { display: block; color: var(--unity-meta-category); }
        .unity-product-meta .unity-product-partno { display: block; margin-top: 0.35rem; color: var(--unity-meta-partno); }
        .unity-product-meta .unity-product-category:not(:empty) + .unity-product-partno:before { content: none; }
        .unity-product-actions {
            padding: 0 1rem 1rem;
            opacity: 0;
            transform: translateY(4px);
            transition: opacity 0.2s var(--unity-ease), transform 0.2s var(--unity-ease);
        }
        .unity-product-card:hover .unity-product-actions {
            opacity: 1;
            transform: translateY(0);
        }
        .unity-btn-add {
            width: 100%;
            border-radius: 0;
            background: var(--unity-text);
            color: var(--unity-bg);
            border-color: var(--unity-text);
        }
        .unity-btn-add:hover { opacity: 0.9; }

        /* ----- Phone only: one product per row, square image left, details right, big Add to Cart ----- */
        @media (max-width: 767.98px) {
            .unity-product-col {
                flex: 0 0 100%;
                max-width: 100%;
                margin-bottom: 1rem;
            }
            .unity-product-card {
                flex-direction: column;
                align-items: stretch;
                gap: 0;
            }
            .unity-product-link {
                display: flex;
                flex-direction: row;
                flex: 1;
                min-width: 0;
                padding: 0;
            }
            .unity-product-image {
                flex-shrink: 0;
                width: 160px;
                min-width: 160px;
                aspect-ratio: 1/1;
                border-right: 1px solid var(--unity-border);
            }
            .unity-product-image img {
                object-fit: contain;
            }
            .unity-product-details {
                flex: 1;
                min-width: 0;
                flex-direction: column;
                align-items: stretch;
                padding: 0.75rem 1rem;
                gap: 0;
            }
            .unity-product-name {
                font-size: 14px;
                font-weight: 600;
                color: var(--unity-desc);
                -webkit-line-clamp: 3;
                flex: none;
                margin-bottom: 0.5rem;
            }
            .unity-product-price {
                font-size: 1rem;
                font-weight: 600;
                color: var(--unity-text);
                margin-bottom: 0.6rem;
            }
            .unity-product-meta {
                display: block;
                font-size: 12px;
                color: var(--unity-meta-partno);
                line-height: 1.5;
                margin-top: 0;
            }
            .unity-product-meta .unity-product-category {
                display: block;
                margin-bottom: 0.4rem;
                color: var(--unity-meta-category);
            }
            .unity-product-meta .unity-product-partno {
                display: block;
                margin-top: 0;
                color: var(--unity-meta-partno);
            }
            .unity-product-actions {
                flex: none;
                padding: 0.6rem 1rem;
                opacity: 1;
                transform: none;
                border-top: 1px solid var(--unity-border);
                width: 100%;
            }
            .unity-product-card .unity-product-actions {
                opacity: 1;
            }
            .unity-btn-add {
                min-height: 40px;
                font-size: 13px;
                font-weight: 600;
                padding: 0.5rem 0.75rem;
            }
        }
        @media (max-width: 575.98px) {
            .unity-product-actions { opacity: 1; transform: none; }
            .unity-product-card .unity-product-actions { opacity: 1; }
        }

        /* Sort */
        .unity-sort-wrap { display: flex; align-items: center; gap: 0.5rem; justify-content: center; flex-wrap: wrap; margin-top: 1rem; }
        .unity-sort-select {
            padding: 0.5rem 0.75rem;
            font-size: 14px;
            font-family: inherit;
            border: 1px solid var(--unity-border);
            border-radius: 0;
            background: var(--unity-bg);
            color: var(--unity-text);
        }

        /* Reveal on scroll */
        .unity-reveal {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s var(--unity-ease), transform 0.5s var(--unity-ease);
        }
        .unity-reveal.revealed { opacity: 1; transform: translateY(0); }

        /* Pagination */
        .pagination-wrapper { margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--unity-border); display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1rem; }
        .pagination-wrapper nav .pagination { display: flex; flex-wrap: wrap; gap: 0.5rem; list-style: none; margin: 0; padding: 0; }
        .pagination-wrapper .page-link, .pagination-wrapper a, .pagination-wrapper span {
            display: inline-flex; align-items: center; justify-content: center; min-width: 2.5rem; height: 2.5rem; padding: 0 0.75rem;
            font-size: 14px; border: 1px solid var(--unity-border); background: var(--unity-bg); color: var(--unity-text); text-decoration: none;
            transition: all 0.2s var(--unity-ease);
        }
        .pagination-wrapper .page-item.active .page-link { background: var(--unity-text); color: var(--unity-bg); border-color: var(--unity-text); }
        .pagination-wrapper .page-item.disabled .page-link { opacity: 0.5; pointer-events: none; }

        /* Alerts, toasts */
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; border-radius: 0; }
        .cart-toast {
            position: fixed;
            bottom: 1.5rem;
            right: 1.5rem;
            z-index: 9999;
            padding: 0.75rem 1.25rem;
            background: var(--unity-text);
            color: var(--unity-bg);
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            border-radius: 0;
            animation: cartToastIn 0.3s var(--unity-ease);
        }
        @keyframes cartToastIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Dropdown (account) */
        .dropdown-menu { background: var(--unity-bg); border: 1px solid var(--unity-border); border-radius: 0; padding: 0.5rem; }
        .dropdown-item { color: var(--unity-text); padding: 0.5rem 1rem; font-size: 14px; }
        .dropdown-item:hover { background: var(--unity-bg-secondary); }

        /* Sticky bottom mobile */
        .unity-sticky-bottom { display: none; }
        @media (max-width: 768px) {
            .unity-sticky-bottom {
                display: flex;
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                z-index: 1040;
                padding: 0.75rem 1rem;
                padding-bottom: max(0.75rem, env(safe-area-inset-bottom));
                background: var(--unity-bg);
                border-top: 1px solid var(--unity-border);
                gap: 0.75rem;
            }
            .unity-sticky-bottom a { flex: 1; text-align: center; padding: 0.75rem; font-size: 14px; font-weight: 500; text-decoration: none; border-radius: 0; transition: background 0.2s var(--unity-ease); }
            .unity-sticky-bottom .sticky-cart { border: 1px solid var(--unity-border); color: var(--unity-text); }
            .unity-sticky-bottom .sticky-checkout { background: var(--unity-text); color: var(--unity-bg); border: 1px solid var(--unity-text); }
            body.unity-has-sticky { padding-bottom: 5rem; }
        }

        #products-infinite-sentinel { height: 1px; visibility: hidden; pointer-events: none; }
        .no-products { text-align: center; padding: 4rem 0; color: var(--unity-text-secondary); }
    </style>
</head>
<body class="unity-has-sticky">
    <!-- Header -->
    <header class="unity-header" id="unityHeader">
        <div class="unity-header-left">
            <button type="button" class="unity-hamburger" id="unityHamburger" aria-label="Menu">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12h18M3 6h18M3 18h18"/></svg>
            </button>
            <a href="{{ route('home') }}" class="unity-logo">Make Your Order</a>
            <nav class="unity-nav-desktop">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                <a href="{{ route('home') }}">Products</a>
            </nav>
        </div>
        <div class="unity-header-right">
            <button type="button" class="unity-icon-btn" id="unitySearchOpen" aria-label="Search">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            </button>
            <button type="button" class="unity-icon-btn" id="unityFilterOpen" aria-label="Filters">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h10M4 18h6"/></svg>
            </button>
            <div class="unity-cart-wrap">
                <button type="button" class="unity-icon-btn" id="unityCartOpen" aria-label="Cart">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                    <span class="unity-cart-badge" id="unityCartBadge" style="display:none;">0</span>
                </button>
            </div>
            @auth
                <div class="dropdown">
                    <button class="unity-icon-btn" type="button" data-bs-toggle="dropdown" aria-label="Account">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
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
                <a href="{{ route('login') }}" class="unity-btn" style="padding: 0.4rem 0.75rem; font-size: 13px;">Login</a>
                <a href="{{ route('register') }}" class="unity-btn unity-btn-primary" style="padding: 0.4rem 0.75rem; font-size: 13px;">Register</a>
            @endauth
        </div>
    </header>

    <!-- Mobile menu (slide from left) -->
    <div class="unity-mobile-menu-overlay" id="unityMobileOverlay"></div>
    <div class="unity-mobile-menu" id="unityMobileMenu">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('home') }}">Products</a>
        <div class="unity-filter-section">
            <strong>Categories</strong>
        </div>
        @if($categories->isNotEmpty())
            @foreach($categories->take(8) as $cat)
                <a href="{{ route('products.byCategory', $cat) }}">{{ $cat->name }}</a>
            @endforeach
        @endif
    </div>

    <!-- Search overlay -->
    <div class="unity-search-overlay" id="unitySearchOverlay">
        <div class="unity-search-overlay-header">
            <div class="unity-search-overlay-input-wrap">
                <form action="{{ route('search.results') }}" method="GET" id="unitySearchForm" role="search">
                    <input type="search" name="q" class="unity-search-overlay-input" id="unitySearchInput" placeholder="Search products..." autocomplete="off" value="{{ $searchQuery ?? '' }}">
                </form>
            </div>
            <button type="button" class="unity-search-overlay-close" id="unitySearchClose">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>
        <div class="unity-search-suggestions" id="unitySearchSuggestions"></div>
    </div>

    <!-- Filter drawer -->
    <div class="unity-filter-drawer-overlay" id="unityFilterOverlay"></div>
    <div class="unity-filter-drawer" id="unityFilterDrawer">
        <div class="unity-filter-drawer-header">Filters</div>
        <div class="unity-filter-drawer-body">
            <p class="unity-section-subtitle mb-2">Shop by category</p>
            @if($categories->isNotEmpty())
                <ul class="unity-category-list">
                    @foreach($categories as $cat)
                        <li class="unity-category-item">
                            <div class="unity-category-row">
                                <span class="unity-category-name">{{ $cat->name }}</span>
                                <a href="{{ route('products.byCategory', $cat) }}" class="unity-category-link">View</a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="unity-section-subtitle">No categories.</p>
            @endif
        </div>
    </div>

    <!-- Cart drawer -->
    <div class="unity-cart-drawer-overlay" id="unityCartOverlay"></div>
    <div class="unity-cart-drawer" id="unityCartDrawer">
        <div class="unity-cart-drawer-header">
            <span>Cart</span>
            <button type="button" class="unity-cart-drawer-close" id="unityCartClose">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>
        <div class="unity-cart-drawer-body" id="unityCartBody">
            <div class="unity-cart-drawer-empty">Loading...</div>
        </div>
        <div class="unity-cart-drawer-footer" id="unityCartFooter" style="display:none;">
            <div class="unity-cart-drawer-subtotal" id="unityCartSubtotal">₹0.00</div>
            <div class="unity-cart-drawer-actions">
                <a href="{{ route('cart.view') }}" class="unity-btn">View cart</a>
                @auth
                    <a href="{{ route('checkout.form') }}" class="unity-btn unity-btn-primary">Checkout</a>
                @else
                    <a href="{{ route('checkout.login-required') }}" class="unity-btn unity-btn-primary">Checkout</a>
                @endauth
            </div>
        </div>
    </div>

    <main class="unity-main">
        @if (session('status'))
            <div class="unity-container unity-section">
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @if(!isset($searchQuery))
        <section class="unity-section unity-categories unity-reveal">
            <div class="unity-container">
                <details class="unity-category-dropdown" @if(!isset($category) || (isset($category) && ($categoryProductCount ?? 0) === 0)) open @endif>
                    <summary>
                        <span>@if(isset($category)){{ $category->name }} categories @else Shop by category @endif</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
                    </summary>
                    <div class="unity-category-dropdown-body">
                        <ul class="unity-category-list">
                            @if($categories->isNotEmpty())
                                @include('products.categories._tree_unity', ['categories' => $categories])
                            @else
                                <li class="unity-category-row"><span class="unity-section-subtitle">No categories.</span></li>
                            @endif
                        </ul>
                    </div>
                </details>
            </div>
        </section>
        @endif

        @if(!isset($category) || isset($searchQuery) || (isset($category) && ($categoryProductCount ?? 0) > 0))
        <section class="unity-section unity-products-section">
            <div class="unity-container">
                <div class="unity-section-title unity-reveal">
                    @if(isset($category) && $category->image_path)
                        <img src="{{ asset($category->image_path) }}" alt="{{ $category->name }}" style="max-width:120px;margin-bottom:1rem;">
                    @endif
                    <h2>
                        @if(isset($searchQuery)) Search results for "{{ $searchQuery }}"
                        @elseif(isset($category)) {{ $category->name }} Products
                        @else Our Products
                        @endif
                    </h2>
                    <p class="unity-section-subtitle">
                        @if(isset($searchQuery)) {{ $products->total() }} product(s) found
                        @elseif(isset($category)) Explore our {{ strtolower($category->name ) }} collection
                        @else Explore our collection
                        @endif
                    </p>
                    @if ($products->count() > 0)
                        @php
                            $baseSortParams = isset($searchQuery) ? array_filter(request()->only(['q'])) : request()->except('sort');
                            $baseSortUrl = request()->url() . (count($baseSortParams) ? '?' . http_build_query($baseSortParams) : '');
                            $sortPriceAsc = $baseSortUrl . (str_contains($baseSortUrl, '?') ? '&' : '?') . 'sort=price_asc';
                            $sortPriceDesc = $baseSortUrl . (str_contains($baseSortUrl, '?') ? '&' : '?') . 'sort=price_desc';
                            $sortBestSellers = $baseSortUrl . (str_contains($baseSortUrl, '?') ? '&' : '?') . 'sort=best_sellers';
                        @endphp
                        <div class="unity-sort-wrap">
                            <label for="sort-by-select" class="unity-section-subtitle mb-0">Sort</label>
                            <select id="sort-by-select" class="unity-sort-select" aria-label="Sort products">
                                <option value="{{ $baseSortUrl }}" {{ !isset($sort) || $sort === null ? 'selected' : '' }}>Newest</option>
                                <option value="{{ $sortPriceAsc }}" {{ (isset($sort) && $sort === 'price_asc') ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="{{ $sortPriceDesc }}" {{ (isset($sort) && $sort === 'price_desc') ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="{{ $sortBestSellers }}" {{ (isset($sort) && $sort === 'best_sellers') ? 'selected' : '' }}>Best Sellers</option>
                            </select>
                        </div>
                    @endif
                </div>

                @if ($products->count())
                    @php
                        $nextUrl = $products->nextPageUrl();
                        $nextUrlRelative = $nextUrl ? parse_url($nextUrl, PHP_URL_PATH) . (parse_url($nextUrl, PHP_URL_QUERY) ? '?' . parse_url($nextUrl, PHP_URL_QUERY) : '') : '';
                    @endphp
                    <div id="products-infinite-container" data-next-url="{{ $nextUrlRelative }}" data-has-more="{{ $products->hasMorePages() ? '1' : '0' }}" data-csrf="{{ csrf_token() }}">
                        <div id="products-grid-row" class="row g-3 g-md-4">
                            @foreach ($products as $product)
                                @include('products._card', ['product' => $product])
                            @endforeach
                        </div>
                        <div id="products-infinite-sentinel" aria-hidden="true"></div>
                        <div id="products-infinite-loading" class="text-center py-4 d-none">
                            <p class="unity-section-subtitle">Loading more...</p>
                        </div>
                        <div id="products-infinite-end" class="text-center py-4 d-none">
                            <p class="unity-section-subtitle">You've seen all products.</p>
                        </div>
                        <div id="products-infinite-error" class="text-center py-4 d-none">
                            <p class="unity-section-subtitle">Failed to load. <button type="button" class="unity-btn btn-sm" id="products-infinite-retry">Retry</button></p>
                        </div>
                    </div>
                @else
                    <div class="no-products unity-reveal">
                        <h3 style="font-weight:600;letter-spacing:-0.02em;margin-bottom:0.5rem;">@if(isset($searchQuery)) No results @else No products yet @endif</h3>
                        <p class="unity-section-subtitle">@if(isset($searchQuery)) Try a different search. @else Check back soon. @endif</p>
                        @if(isset($searchQuery))
                            <a href="{{ route('home') }}" class="unity-btn mt-3">View all</a>
                        @endif
                    </div>
                @endif
            </div>
        </section>
        @endif
    </main>

    <div class="unity-sticky-bottom">
        <a href="{{ route('cart.view') }}" class="sticky-cart">View Cart</a>
        @auth
            <a href="{{ route('checkout.form') }}" class="sticky-checkout">Checkout</a>
        @else
            <a href="{{ route('checkout.login-required') }}" class="sticky-checkout">Checkout</a>
        @endauth
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function() {
            var ease = 'cubic-bezier(0.4, 0, 0.2, 1)';

            // Sticky header scroll
            var header = document.getElementById('unityHeader');
            if (header) {
                window.addEventListener('scroll', function() {
                    header.classList.toggle('scrolled', window.scrollY > 10);
                });
            }

            // Mobile menu
            var hamburger = document.getElementById('unityHamburger');
            var mobileMenu = document.getElementById('unityMobileMenu');
            var mobileOverlay = document.getElementById('unityMobileOverlay');
            function openMobile() { mobileMenu.classList.add('open'); mobileOverlay.classList.add('open'); document.body.style.overflow = 'hidden'; }
            function closeMobile() { mobileMenu.classList.remove('open'); mobileOverlay.classList.remove('open'); document.body.style.overflow = ''; }
            if (hamburger) hamburger.addEventListener('click', openMobile);
            if (mobileOverlay) mobileOverlay.addEventListener('click', closeMobile);

            // Search overlay
            var searchOpen = document.getElementById('unitySearchOpen');
            var searchOverlay = document.getElementById('unitySearchOverlay');
            var searchClose = document.getElementById('unitySearchClose');
            var searchInput = document.getElementById('unitySearchInput');
            if (searchOpen) searchOpen.addEventListener('click', function() { searchOverlay.classList.add('open'); setTimeout(function() { searchInput && searchInput.focus(); }, 100); });
            if (searchClose) searchClose.addEventListener('click', function() { searchOverlay.classList.remove('open'); });
            if (searchOverlay) searchOverlay.addEventListener('keydown', function(e) { if (e.key === 'Escape') searchOverlay.classList.remove('open'); });

            // Filter drawer
            var filterOpen = document.getElementById('unityFilterOpen');
            var filterDrawer = document.getElementById('unityFilterDrawer');
            var filterOverlay = document.getElementById('unityFilterOverlay');
            if (filterOpen) filterOpen.addEventListener('click', function() { filterDrawer.classList.add('open'); filterOverlay.classList.add('open'); });
            if (filterOverlay) filterOverlay.addEventListener('click', function() { filterDrawer.classList.remove('open'); filterOverlay.classList.remove('open'); });

            // Cart drawer
            var cartOpen = document.getElementById('unityCartOpen');
            var cartDrawer = document.getElementById('unityCartDrawer');
            var cartOverlay = document.getElementById('unityCartOverlay');
            var cartClose = document.getElementById('unityCartClose');
            var cartBody = document.getElementById('unityCartBody');
            var cartFooter = document.getElementById('unityCartFooter');
            var cartSubtotal = document.getElementById('unityCartSubtotal');
            var cartBadge = document.getElementById('unityCartBadge');
            var drawerUrl = '{{ route("cart.drawer") }}';

            function loadCartDrawer() {
                fetch(drawerUrl, { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(function(r) { return r.json(); })
                    .then(function(data) {
                        if (cartBadge) {
                            cartBadge.textContent = data.count;
                            cartBadge.style.display = data.count > 0 ? 'flex' : 'none';
                        }
                        if (data.items.length === 0) {
                            cartBody.innerHTML = '<div class="unity-cart-drawer-empty">Your cart is empty.</div>';
                            if (cartFooter) cartFooter.style.display = 'none';
                        } else {
                            var csrf = '{{ csrf_token() }}';
                            var html = data.items.map(function(item) {
                                var img = item.image_path ? '<img src="' + escapeAttr(item.image_path) + '" alt="">' : '<div style="width:64px;height:80px;background:var(--unity-bg-secondary);"></div>';
                                var remove = data.authenticated ? '<form method="POST" action="' + escapeAttr(item.remove_url) + '" class="unity-cart-remove-form mt-1"><input type="hidden" name="_token" value="' + escapeAttr(csrf) + '"><input type="hidden" name="_method" value="DELETE"><button type="submit" class="unity-btn" style="padding:0.25rem 0.5rem;font-size:12px;">Remove</button></form>' : '';
                                return '<div class="unity-cart-drawer-item"><a href="' + escapeAttr(item.show_url) + '">' + img + '</a><div class="unity-cart-drawer-item-info"><a href="' + escapeAttr(item.show_url) + '" class="unity-cart-drawer-item-name">' + escapeHtml(item.name) + '</a><div class="unity-cart-drawer-item-meta">Qty ' + item.quantity + ' · ₹' + parseFloat(item.subtotal).toFixed(2) + '</div>' + remove + '</div></div>';
                            }).join('');
                            cartBody.innerHTML = html;
                            if (cartFooter) cartFooter.style.display = 'block';
                            if (cartSubtotal) cartSubtotal.textContent = '₹' + parseFloat(data.subtotal).toFixed(2);
                            cartBody.querySelectorAll('form.unity-cart-remove-form').forEach(function(f) {
                                f.addEventListener('submit', function(e) {
                                    e.preventDefault();
                                    var form = this;
                                    var fd = new FormData(form);
                                    fetch(form.action, { method: 'POST', headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }, body: fd }).then(function() { loadCartDrawer(); });
                                });
                            });
                        }
                    })
                    .catch(function() {
                        cartBody.innerHTML = '<div class="unity-cart-drawer-empty">Could not load cart.</div>';
                        if (cartFooter) cartFooter.style.display = 'none';
                    });
            }
            function escapeHtml(s) { if (!s) return ''; var d = document.createElement('div'); d.textContent = s; return d.innerHTML; }
            function escapeAttr(s) { return escapeHtml(s).replace(/"/g, '&quot;'); }

            if (cartOpen) cartOpen.addEventListener('click', function() { cartDrawer.classList.add('open'); cartOverlay.classList.add('open'); loadCartDrawer(); });
            if (cartClose) cartClose.addEventListener('click', function() { cartDrawer.classList.remove('open'); cartOverlay.classList.remove('open'); });
            if (cartOverlay) cartOverlay.addEventListener('click', function() { cartDrawer.classList.remove('open'); cartOverlay.classList.remove('open'); });
            loadCartDrawer();

            // Reveal on scroll
            var reveals = document.querySelectorAll('.unity-reveal');
            var observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) entry.target.classList.add('revealed');
                });
            }, { rootMargin: '0px 0px -40px 0px', threshold: 0.1 });
            reveals.forEach(function(el) { observer.observe(el); });

            window.unityLoadCartDrawer = loadCartDrawer;
        })();
    </script>
    <script>
        // Search autocomplete (overlay input)
        (function() {
            function escHtml(s) { if (!s) return ''; var d = document.createElement('div'); d.textContent = s; return d.innerHTML; }
            function escAttr(s) { return escHtml(s).replace(/"/g, '&quot;'); }
            var input = document.getElementById('unitySearchInput');
            var form = document.getElementById('unitySearchForm');
            var suggestionsEl = document.getElementById('unitySearchSuggestions');
            var suggestionsUrl = '{{ route("search.suggestions") }}';
            var debounce = null;
            if (!input || !suggestionsEl) return;
            input.addEventListener('input', function() {
                var q = input.value.trim();
                clearTimeout(debounce);
                if (!q) { suggestionsEl.innerHTML = ''; return; }
                debounce = setTimeout(function() {
                    fetch(suggestionsUrl + '?q=' + encodeURIComponent(q), { headers: { 'Accept': 'application/json' } })
                        .then(function(r) { return r.json(); })
                        .then(function(res) {
                            var data = res.data || [];
                            if (data.length === 0) suggestionsEl.innerHTML = '<div class="unity-search-suggestion-item" style="pointer-events:none;">No suggestions</div>';
                            else {
                                var viewAllUrl = '{{ route("search.results") }}?q=' + encodeURIComponent(q);
                                suggestionsEl.innerHTML = data.map(function(p) {
                                    var img = p.image_path ? '<img src="' + escAttr(p.image_path) + '" alt="">' : '';
                                    return '<a href="' + escAttr(p.show_url || '#') + '" class="unity-search-suggestion-item"><div style="width:48px;height:48px;background:var(--unity-bg-secondary);flex-shrink:0;overflow:hidden;">' + img + '</div><div><div>' + escHtml(p.name || '') + '</div><span class="price">₹' + escHtml(p.price || '') + '</span></div></a>';
                                }).join('') + '<a href="' + viewAllUrl + '" class="unity-search-suggestion-item" style="justify-content:center;">View all results</a>';
                            }
                        });
                }, 300);
            });
        })();

        function showCartToast() {
            var existing = document.getElementById('cart-toast');
            if (existing) existing.remove();
            var toast = document.createElement('div');
            toast.id = 'cart-toast';
            toast.className = 'cart-toast';
            toast.innerHTML = 'Added to cart';
            document.body.appendChild(toast);
            setTimeout(function() { if (toast.parentNode) toast.remove(); }, 2500);
            if (window.unityLoadCartDrawer) window.unityLoadCartDrawer();
        }

        function submitCartFormAjax(form, button) {
            var origHtml = button ? button.innerHTML : '';
            if (button) { button.innerHTML = 'Adding...'; button.disabled = true; }
            fetch(form.action, { method: 'POST', body: new FormData(form), headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
                .then(function(r) { return r.json(); })
                .then(function() { showCartToast(); if (button) { button.innerHTML = origHtml; button.disabled = false; } })
                .catch(function() { if (button) { button.innerHTML = origHtml; button.disabled = false; } showCartToast(); });
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('form[action*="/cart/"]').forEach(function(form) {
                if (form.dataset.bound) return;
                form.dataset.bound = '1';
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    submitCartFormAjax(this, this.querySelector('button[type="submit"]'));
                });
            });

            var sortSelect = document.getElementById('sort-by-select');
            if (sortSelect) sortSelect.addEventListener('change', function() { if (this.value) window.location.href = this.value; });

            // Infinite scroll
            var container = document.getElementById('products-infinite-container');
            if (container) {
                var gridRow = document.getElementById('products-grid-row');
                var sentinel = document.getElementById('products-infinite-sentinel');
                var loadingEl = document.getElementById('products-infinite-loading');
                var endEl = document.getElementById('products-infinite-end');
                var errorEl = document.getElementById('products-infinite-error');
                var retryBtn = document.getElementById('products-infinite-retry');
                var nextUrl = container.getAttribute('data-next-url') || '';
                var hasMore = container.getAttribute('data-has-more') === '1';
                var csrf = container.getAttribute('data-csrf') || '';

function buildCard(p) {
                                    var img = p.image_path ? '<img src="' + (p.image_path.replace(/"/g, '&quot;')) + '" alt="">' : '<div class="unity-product-image-placeholder"><svg class="unity-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg></div>';
                                    var name = (p.name || '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
                                    var cat = (p.category_name || '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
                                    var partNo = (p.company_part_number || '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
                                    var meta = (cat || partNo) ? '<div class="unity-product-meta"><span class="unity-product-category">' + cat + '</span><span class="unity-product-partno">' + partNo + '</span></div>' : '';
                                    return '<div class="col-6 col-md-4 col-lg-3 unity-product-col"><div class="unity-product-card"><a href="' + (p.show_url || '#').replace(/"/g, '&quot;') + '" class="unity-product-link"><div class="unity-product-image">' + img + '</div><div class="unity-product-details"><span class="unity-product-name">' + name + '</span><span class="unity-product-price">₹' + (p.price || '') + '</span>' + meta + '</div></a><div class="unity-product-actions"><form method="POST" action="' + (p.add_to_cart_url || '').replace(/"/g, '&quot;') + '" class="unity-add-form"><input type="hidden" name="_token" value="' + csrf + '"><input type="hidden" name="quantity" value="1"><button type="submit" class="unity-btn unity-btn-add">Add to Cart</button></form></div></div></div>';
                                }

                var loading = false;
                var observer = new IntersectionObserver(function(entries) {
                    if (!entries[0].isIntersecting || loading || !hasMore || !nextUrl) return;
                    loading = true;
                    if (loadingEl) loadingEl.classList.remove('d-none');
                    fetch(nextUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
                        .then(function(r) { return r.json(); })
                        .then(function(json) {
                            loading = false;
                            if (loadingEl) loadingEl.classList.add('d-none');
                            if (json.data && json.data.length) {
                                json.data.forEach(function(p) {
                                    var div = document.createElement('div');
                                    div.innerHTML = buildCard(p);
                                    gridRow.appendChild(div.firstChild);
                                });
                                document.querySelectorAll('#products-grid-row form[action*="/cart/"]').forEach(function(form) {
                                    if (form.dataset.bound) return;
                                    form.dataset.bound = '1';
                                    form.addEventListener('submit', function(e) { e.preventDefault(); submitCartFormAjax(this, this.querySelector('button')); });
                                });
                            }
                            nextUrl = json.next_page_url || '';
                            hasMore = !!json.has_more_pages;
                            container.setAttribute('data-next-url', nextUrl);
                            container.setAttribute('data-has-more', hasMore ? '1' : '0');
                            if (!hasMore && endEl) endEl.classList.remove('d-none');
                        })
                        .catch(function() { loading = false; if (loadingEl) loadingEl.classList.add('d-none'); if (errorEl) errorEl.classList.remove('d-none'); });
                }, { rootMargin: '200px 0px', threshold: 0 });
                if (sentinel) observer.observe(sentinel);
                if (retryBtn) retryBtn.addEventListener('click', function() { errorEl.classList.add('d-none'); if (nextUrl) { loading = false; observer.unobserve(sentinel); observer.observe(sentinel); } });
            }

            function toggleUnityCategory(categoryId) {
                var childrenList = document.getElementById('unity-children-' + categoryId);
                var icon = document.getElementById('unity-icon-' + categoryId);
                if (childrenList && icon) {
                    if (childrenList.classList.contains('hidden')) {
                        childrenList.classList.remove('hidden');
                        icon.textContent = '▼';
                    } else {
                        childrenList.classList.add('hidden');
                        icon.textContent = '▶';
                    }
                }
            }
            window.toggleUnityCategory = toggleUnityCategory;
        });
    </script>
</body>
</html> --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Growzio — Products</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        /* =============================================
           GROWZIO — DESIGN SYSTEM
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

        /* ── Reset & Scrollbar ─────────────────────── */
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        html {
            scroll-behavior: smooth;
        }

        /* Native scrollbar — styled to match theme */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: var(--g-bg2); }
        ::-webkit-scrollbar-thumb {
            background: var(--g-accent);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover { background: #e8bc52; }
        /* Firefox */
        * { scrollbar-width: thin; scrollbar-color: var(--g-accent) var(--g-bg2); }

        body {
            background: var(--g-bg);
            font-family: var(--font-body);
            font-size: 16px;
            line-height: 1.6;
            color: var(--g-text);
            overflow-x: hidden;
        }

        /* ── Typography ────────────────────────────── */
        h1,h2,h3,h4,h5,h6 { font-family: var(--font-head); }
        .mono { font-family: var(--font-mono); }

        /* ── Animations ─────────────────────────────── */
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

        /* ── Reveal on scroll ───────────────────────── */
        .g-reveal {
            opacity: 0;
            transform: translateY(32px);
            transition: opacity 0.65s var(--g-ease), transform 0.65s var(--g-ease);
        }
        .g-reveal.g-revealed {
            opacity: 1;
            transform: translateY(0);
        }
        .g-reveal-delay-1 { transition-delay: 0.1s; }
        .g-reveal-delay-2 { transition-delay: 0.2s; }
        .g-reveal-delay-3 { transition-delay: 0.3s; }

        /* ── Header ────────────────────────────────── */
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
        .g-icon-btn:active { transform: scale(0.95); }

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
            animation: pulse-glow 2s ease infinite;
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

        /* ── Auth buttons ───────────────────────────── */
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

        /* ── Mobile menu ────────────────────────────── */
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

        .g-mobile-menu a,
        .g-mobile-menu .g-filter-sect {
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
        .g-mobile-menu .g-filter-sect {
            font-size: 11px;
            font-family: var(--font-mono);
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: var(--g-accent);
            pointer-events: none;
        }

        /* ── Search overlay ─────────────────────────── */
        .g-search-overlay {
            position: fixed; inset: 0;
            background: rgba(34,40,49,0.97);
            backdrop-filter: blur(20px);
            z-index: 1100;
            display: flex; flex-direction: column;
            opacity: 0; visibility: hidden;
            transition: opacity 0.25s, visibility 0.25s;
        }
        .g-search-overlay.open { opacity: 1; visibility: visible; }

        .g-search-header {
            display: flex; align-items: center;
            border-bottom: 1px solid var(--g-border);
            padding: 1rem 1.5rem;
        }
        .g-search-input-wrap { flex: 1; margin: 0 1rem; }
        .g-search-input {
            width: 100%;
            padding: 0.875rem 1rem;
            font-size: 1.1rem;
            font-family: var(--font-body);
            background: var(--g-bg2);
            border: 1px solid var(--g-border);
            border-radius: var(--g-radius);
            color: var(--g-text);
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .g-search-input::placeholder { color: var(--g-text-muted); }
        .g-search-input:focus {
            border-color: var(--g-accent);
            box-shadow: 0 0 0 3px rgba(255,211,105,0.12);
        }

        .g-suggestions { flex: 1; overflow-y: auto; padding: 1rem; max-width: 680px; margin: 0 auto; width: 100%; }
        .g-suggestion-item {
            display: flex; align-items: center; gap: 1rem;
            padding: 0.75rem;
            border-radius: var(--g-radius);
            text-decoration: none;
            color: var(--g-text);
            transition: background 0.2s;
        }
        .g-suggestion-item:hover { background: var(--g-bg2); }
        .g-suggestion-item img { width: 48px; height: 48px; object-fit: cover; border-radius: var(--g-radius); }
        .g-suggestion-item .price { font-size: 13px; color: var(--g-text-muted); font-family: var(--font-mono); }

        /* ── Filter drawer ──────────────────────────── */
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

        /* ── Cart drawer ────────────────────────────── */
        .g-cart-overlay {
            position: fixed; inset: 0;
            background: rgba(34,40,49,0.7);
            backdrop-filter: blur(4px);
            z-index: 1055;
            opacity: 0; visibility: hidden;
            transition: opacity 0.3s, visibility 0.3s;
        }
        .g-cart-overlay.open { opacity: 1; visibility: visible; }

        .g-cart-drawer {
            position: fixed; top: 0; right: 0;
            width: 390px; max-width: 100vw;
            height: 100vh;
            background: var(--g-bg2);
            border-left: 1px solid var(--g-border);
            z-index: 1060;
            display: flex; flex-direction: column;
            transform: translateX(100%);
            transition: transform 0.35s var(--g-ease);
        }
        .g-cart-drawer.open { transform: translateX(0); }

        .g-cart-header {
            padding: 1.25rem;
            border-bottom: 1px solid var(--g-border);
            display: flex; align-items: center; justify-content: space-between;
        }
        .g-cart-title {
            font-family: var(--font-head);
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--g-light);
            display: flex; align-items: center; gap: 0.5rem;
        }
        .g-cart-title::before {
            content: '';
            display: inline-block;
            width: 3px; height: 18px;
            background: var(--g-accent);
            border-radius: 2px;
        }
        .g-cart-close-btn {
            width: 36px; height: 36px;
            display: flex; align-items: center; justify-content: center;
            border: 1px solid var(--g-border);
            background: transparent;
            color: var(--g-text-muted);
            cursor: pointer;
            border-radius: var(--g-radius);
            transition: all 0.2s;
        }
        .g-cart-close-btn:hover { color: var(--g-accent); border-color: var(--g-border-hover); }

        .g-cart-body { flex: 1; overflow-y: auto; padding: 1rem; }
        .g-cart-item {
            display: flex; gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid var(--g-border);
            animation: fadeUp 0.3s var(--g-ease);
        }
        .g-cart-item img {
            width: 64px; height: 80px;
            object-fit: cover;
            border-radius: var(--g-radius);
            background: var(--g-bg);
        }
        .g-cart-item-info { flex: 1; min-width: 0; }
        .g-cart-item-name { font-size: 13.5px; font-weight: 500; color: var(--g-light); margin-bottom: 0.2rem; }
        .g-cart-item-meta { font-size: 13px; color: var(--g-text-muted); font-family: var(--font-mono); }

        .g-cart-footer {
            padding: 1.25rem;
            border-top: 1px solid var(--g-border);
            background: var(--g-bg);
        }
        .g-cart-subtotal {
            font-family: var(--font-head);
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--g-accent);
            margin-bottom: 1rem;
        }
        .g-cart-actions { display: flex; flex-direction: column; gap: 0.5rem; }
        .g-cart-empty {
            padding: 3rem 1rem;
            text-align: center;
            color: var(--g-text-muted);
            font-size: 14px;
        }

        /* ── Buttons (main) ─────────────────────────── */
        .g-btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 0.4rem;
            padding: 0.7rem 1.25rem;
            font-size: 14px;
            font-family: var(--font-body);
            font-weight: 500;
            border-radius: var(--g-radius);
            cursor: pointer;
            text-decoration: none;
            border: 1px solid var(--g-border);
            background: transparent;
            color: var(--g-text);
            transition: all 0.2s var(--g-ease);
        }
        .g-btn:hover { border-color: rgba(238,238,238,0.25); background: rgba(238,238,238,0.05); color: var(--g-light); }

        .g-btn-primary {
            background: var(--g-accent);
            color: var(--g-bg);
            border-color: var(--g-accent);
            font-weight: 600;
        }
        .g-btn-primary:hover {
            background: #e8bc52;
            border-color: #e8bc52;
            color: var(--g-bg);
            box-shadow: 0 6px 24px rgba(255,211,105,0.28);
            transform: translateY(-1px);
        }

        /* ── Main layout ────────────────────────────── */
        .g-main { padding-top: 0; }
        .g-section { padding: 48px 1.25rem; }
        @media (min-width: 992px)  { .g-section { padding: 80px 2rem; } }
        @media (min-width: 1200px) { .g-section { padding: 96px 2.5rem; } }
        .g-container { max-width: 1320px; margin: 0 auto; }

        /* ── Hero band ──────────────────────────────── */
        .g-hero-band {
            background: var(--g-bg2);
            border-bottom: 1px solid var(--g-border);
            padding: 2.5rem 1.25rem 2rem;
            overflow: hidden;
            position: relative;
        }
        .g-hero-band::before {
            content: '';
            position: absolute;
            top: -80px; right: -120px;
            width: 320px; height: 320px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255,211,105,0.07) 0%, transparent 70%);
            pointer-events: none;
        }
        .g-hero-eyebrow {
            font-family: var(--font-mono);
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: var(--g-accent);
            margin-bottom: 0.6rem;
            animation: slideRight 0.5s var(--g-ease) both;
        }
        .g-hero-title {
            font-family: var(--font-head);
            font-size: clamp(1.8rem, 4vw, 2.8rem);
            font-weight: 800;
            color: var(--g-light);
            letter-spacing: -0.03em;
            line-height: 1.15;
            margin-bottom: 0.6rem;
            animation: fadeUp 0.55s var(--g-ease) 0.05s both;
        }
        .g-hero-title span { color: var(--g-accent); }
        .g-hero-sub {
            font-size: 14.5px;
            color: var(--g-text-muted);
            animation: fadeUp 0.55s var(--g-ease) 0.12s both;
        }
        .g-hero-search {
            max-width: 720px;
            margin-top: 1rem;
            position: relative;
            animation: fadeUp 0.55s var(--g-ease) 0.12s both;
        }
        .g-hero-search .g-search-input-wrap { margin: 0; }
        .g-hero-search .g-search-input {
            padding: 0.85rem 1rem;
            font-size: 1rem;
        }
        .g-hero-suggestions {
            position: absolute;
            top: calc(100% + 10px);
            left: 0;
            right: 0;
            z-index: 50;
            background: rgba(34,40,49,0.98);
            border: 1px solid var(--g-border);
            border-radius: var(--g-radius-lg);
            box-shadow: 0 18px 60px rgba(0,0,0,0.55);
            overflow: hidden;
            max-height: min(420px, 55vh);
            overflow-y: auto;
            padding: 0.5rem;
        }
        .g-hero-suggestions:empty { display: none; }
        .g-hero-suggestions .g-suggestion-item { border-radius: var(--g-radius); }
        .g-accent-line {
            width: 0;
            height: 3px;
            background: var(--g-accent);
            border-radius: 2px;
            margin: 1rem 0 0;
            animation: accentBar 0.6s var(--g-ease) 0.3s both;
        }

        /* ── Categories section ─────────────────────── */
        .g-categories-section { background: var(--g-bg); }
        .g-category-dropdown {
            background: var(--g-bg2);
            border: 1px solid var(--g-border);
            border-radius: var(--g-radius-lg);
            max-width: 980px;
            margin: 0 auto;
            overflow: hidden;
        }
        .g-category-dropdown summary {
            list-style: none;
            cursor: pointer;
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-family: var(--font-head);
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--g-light);
            transition: background 0.2s;
        }
        .g-category-dropdown summary::-webkit-details-marker { display: none; }
        .g-category-dropdown summary:hover { background: rgba(255,211,105,0.05); }
        .g-category-dropdown summary .g-chev {
            transition: transform 0.3s var(--g-ease);
            color: var(--g-accent);
        }
        .g-category-dropdown[open] summary .g-chev { transform: rotate(180deg); }
        .g-category-dropdown-body { border-top: 1px solid var(--g-border); }

        .g-category-list { list-style: none; }
        .g-category-item { border-bottom: 1px solid var(--g-border); }
        .g-category-item:last-child { border-bottom: none; }
        .g-category-row {
            display: flex; align-items: center; justify-content: space-between; gap: 1rem;
            padding: 0.7rem 1.25rem;
            transition: background 0.2s;
        }
        .g-category-row:hover { background: rgba(255,211,105,0.04); }
        .g-category-name { font-size: 13.5px; color: var(--g-text-muted); }
        .g-category-link {
            font-size: 13px;
            font-weight: 500;
            color: var(--g-accent);
            text-decoration: none;
            opacity: 0.8;
            transition: opacity 0.2s;
        }
        .g-category-link:hover { opacity: 1; }
        .g-category-children { list-style: none; padding-left: 1.5rem; border-left: 2px solid rgba(255,211,105,0.2); margin-left: 1.25rem; }
        .g-category-children.hidden { display: none; }
        .g-category-children[hidden] { display: none !important; }

        /* ── Section header ─────────────────────────── */
        .g-section-head {
            text-align: center;
            margin-bottom: 3rem;
        }
        .g-section-eyebrow {
            font-family: var(--font-mono);
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: var(--g-accent);
            margin-bottom: 0.6rem;
        }
        .g-section-title {
            font-family: var(--font-head);
            font-size: clamp(1.5rem, 3vw, 2.2rem);
            font-weight: 800;
            letter-spacing: -0.03em;
            color: var(--g-light);
            margin-bottom: 0.5rem;
        }
        .g-section-sub { font-size: 14px; color: var(--g-text-muted); }

        /* ── Sort ───────────────────────────────────── */
        .g-sort-wrap { display: flex; align-items: center; gap: 0.75rem; justify-content: center; flex-wrap: wrap; margin-top: 1.25rem; }
        .g-sort-label { font-size: 13px; color: var(--g-text-muted); font-family: var(--font-mono); }
        .g-sort-select {
            padding: 0.45rem 0.9rem;
            font-size: 13px;
            font-family: var(--font-body);
            font-weight: 500;
            border: 1px solid var(--g-border);
            border-radius: var(--g-radius);
            background: var(--g-bg2);
            color: var(--g-text);
            outline: none;
            cursor: pointer;
            transition: border-color 0.2s, box-shadow 0.2s;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23FFD369' stroke-width='2'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            padding-right: 2rem;
        }
        .g-sort-select:focus { border-color: var(--g-accent); box-shadow: 0 0 0 3px rgba(255,211,105,0.1); }

        /* ── Product cards ──────────────────────────── */
        .g-products-section { background: var(--g-bg); }

        .g-product-col { margin-bottom: 1.5rem; }

        .g-product-card {
            position: relative;
            background: var(--g-card-bg);
            border: 1px solid var(--g-border);
            border-radius: var(--g-radius-lg);
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: border-color 0.3s, box-shadow 0.3s, transform 0.3s var(--g-ease-spring);
            cursor: pointer;
        }
        .g-product-card:hover {
            border-color: var(--g-border-hover);
            box-shadow: 0 12px 48px rgba(0,0,0,0.35), 0 0 0 1px rgba(255,211,105,0.12);
            transform: translateY(-4px);
        }

        /* Badge */
        .g-product-badge {
            position: absolute;
            top: 10px; left: 10px;
            z-index: 2;
            font-family: var(--font-mono);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            padding: 2px 8px;
            border-radius: 3px;
            background: var(--g-accent);
            color: var(--g-bg);
        }

        .g-product-link { text-decoration: none; color: inherit; display: block; flex: 1; }
        .g-product-image {
            aspect-ratio: 4/5;
            background: var(--g-bg2);
            overflow: hidden;
            position: relative;
        }
        .g-product-image img {
            width: 100%; height: 100%;
            object-fit: contain;
            transition: transform 0.5s var(--g-ease), filter 0.3s;
            padding: 12px;
        }
        .g-product-card:hover .g-product-image img {
            transform: scale(1.06);
            filter: brightness(1.05);
        }

        /* shimmer loading placeholder */
        .g-product-image-placeholder {
            width: 100%; height: 100%;
            display: flex; align-items: center; justify-content: center;
            color: var(--g-text-muted);
            background: linear-gradient(90deg, var(--g-bg2) 25%, rgba(57,62,70,0.8) 50%, var(--g-bg2) 75%);
            background-size: 400px 100%;
            animation: shimmer 1.5s ease infinite;
        }

        .g-product-details {
            padding: 0.9rem 1rem 0.5rem;
            display: flex; flex-wrap: wrap;
            align-items: baseline;
            gap: 0.4rem;
        }
        .g-product-name {
            font-size: 13.5px;
            font-weight: 500;
            color: var(--g-light);
            flex: 1; min-width: 0;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.45;
        }
        .g-product-price {
            font-family: var(--font-mono);
            font-size: 13px;
            font-weight: 500;
            color: var(--g-accent);
        }
        .g-product-meta {
            display: none;
            font-size: 11.5px;
            color: var(--g-text-muted);
            width: 100%;
            margin-top: 0.2rem;
        }
        .g-product-meta .g-product-category { display: block; }
        .g-product-meta .g-product-partno   { display: block; margin-top: 0.2rem; font-family: var(--font-mono); }

        .g-product-actions {
            padding: 0 1rem 1rem;
            opacity: 0;
            transform: translateY(5px);
            transition: opacity 0.25s var(--g-ease), transform 0.25s var(--g-ease);
        }
        .g-product-card:hover .g-product-actions {
            opacity: 1; transform: translateY(0);
        }
        .g-btn-add {
            width: 100%;
            background: var(--g-accent);
            color: var(--g-bg);
            border: 1px solid var(--g-accent);
            border-radius: var(--g-radius);
            font-weight: 600;
            font-size: 13px;
            padding: 0.6rem 1rem;
            display: flex; align-items: center; justify-content: center; gap: 0.4rem;
            cursor: pointer;
            transition: all 0.2s var(--g-ease);
        }
        .g-btn-add:hover {
            background: #e8bc52;
            border-color: #e8bc52;
            box-shadow: 0 4px 20px rgba(255,211,105,0.3);
        }

        /* ── Mobile cards (list view) ───────────────── */
        @media (max-width: 767.98px) {
            .g-product-col { flex: 0 0 100%; max-width: 100%; margin-bottom: 0.75rem; }
            .g-product-card { flex-direction: column; }
            .g-product-link { display: flex; flex-direction: row; flex: 1; min-width: 0; }
            .g-product-image {
                flex-shrink: 0;
                width: 130px; min-width: 130px;
                aspect-ratio: 1/1;
                border-right: 1px solid var(--g-border);
                border-radius: 0;
            }
            .g-product-image img { padding: 8px; }
            .g-product-details {
                flex: 1; min-width: 0;
                flex-direction: column; align-items: stretch;
                padding: 0.75rem 1rem;
                gap: 0;
            }
            .g-product-name { font-size: 13.5px; font-weight: 600; -webkit-line-clamp: 3; flex: none; margin-bottom: 0.35rem; }
            .g-product-price { font-size: 0.95rem; margin-bottom: 0.4rem; }
            .g-product-meta { display: block; }
            .g-product-actions {
                flex: none;
                padding: 0.6rem 0.9rem;
                opacity: 1; transform: none;
                border-top: 1px solid var(--g-border);
                width: 100%;
            }
            .g-product-card .g-product-actions { opacity: 1; }
            .g-btn-add { min-height: 38px; font-size: 13px; }
        }
        @media (max-width: 575.98px) {
            .g-product-actions { opacity: 1; transform: none; }
        }

        /* ── Infinite scroll states ─────────────────── */
        #products-infinite-sentinel { height: 1px; visibility: hidden; pointer-events: none; }
        .no-products {
            text-align: center; padding: 5rem 0;
            color: var(--g-text-muted);
        }
        .no-products h3 {
            font-family: var(--font-head);
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--g-light);
            margin-bottom: 0.5rem;
        }

        /* ── Pagination ─────────────────────────────── */
        .g-pagination-wrap {
            margin-top: 2.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--g-border);
            display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 1rem;
        }
        .g-pagination-wrap nav .pagination { display: flex; flex-wrap: wrap; gap: 0.4rem; list-style: none; margin: 0; padding: 0; }
        .g-pagination-wrap .page-link {
            display: inline-flex; align-items: center; justify-content: center;
            min-width: 38px; height: 38px; padding: 0 0.7rem;
            font-size: 13px; font-family: var(--font-mono);
            border: 1px solid var(--g-border);
            background: var(--g-bg2);
            color: var(--g-text-muted);
            text-decoration: none;
            border-radius: var(--g-radius);
            transition: all 0.2s;
        }
        .g-pagination-wrap .page-link:hover { border-color: var(--g-border-hover); color: var(--g-accent); }
        .g-pagination-wrap .page-item.active .page-link {
            background: var(--g-accent); color: var(--g-bg);
            border-color: var(--g-accent); font-weight: 700;
        }
        .g-pagination-wrap .page-item.disabled .page-link { opacity: 0.3; pointer-events: none; }

        /* ── Toast ──────────────────────────────────── */
        .g-toast {
            position: fixed; bottom: 1.5rem; right: 1.5rem;
            z-index: 9999;
            padding: 0.75rem 1.25rem;
            background: var(--g-bg2);
            border: 1px solid var(--g-border-hover);
            color: var(--g-light);
            font-size: 13.5px; font-weight: 500;
            display: flex; align-items: center; gap: 0.6rem;
            border-radius: var(--g-radius-lg);
            box-shadow: 0 8px 32px rgba(0,0,0,0.4);
            animation: toastSlide 0.35s var(--g-ease-spring);
        }
        .g-toast-icon { color: var(--g-accent); }

        /* ── Dropdown (account) ─────────────────────── */
        .dropdown-menu {
            background: var(--g-bg2);
            border: 1px solid var(--g-border);
            border-radius: var(--g-radius-lg);
            padding: 0.5rem;
            box-shadow: 0 12px 40px rgba(0,0,0,0.4);
        }
        .dropdown-item { color: var(--g-text-muted); padding: 0.55rem 0.9rem; font-size: 13.5px; border-radius: var(--g-radius); }
        .dropdown-item:hover { background: rgba(255,211,105,0.08); color: var(--g-accent); }
        .dropdown-divider { border-color: var(--g-border); }

        /* ── Sticky bottom mobile ───────────────────── */
        .g-sticky-bottom { display: none; }
        @media (max-width: 768px) {
            .g-sticky-bottom {
                display: flex;
                position: fixed; bottom: 0; left: 0; right: 0;
                z-index: 1040;
                padding: 0.75rem 1rem;
                padding-bottom: max(0.75rem, env(safe-area-inset-bottom));
                background: var(--g-bg2);
                border-top: 1px solid var(--g-border);
                backdrop-filter: blur(10px);
                gap: 0.75rem;
            }
            .g-sticky-bottom a {
                flex: 1; text-align: center;
                padding: 0.75rem; font-size: 14px; font-weight: 600;
                text-decoration: none; border-radius: var(--g-radius);
                transition: all 0.2s;
                font-family: var(--font-body);
            }
            .g-sticky-cart { border: 1px solid var(--g-border); color: var(--g-text); }
            .g-sticky-cart:hover { border-color: var(--g-border-hover); color: var(--g-accent); }
            .g-sticky-checkout { background: var(--g-accent); color: var(--g-bg); border: 1px solid var(--g-accent); }
            .g-sticky-checkout:hover { background: #e8bc52; }
            body.g-has-sticky { padding-bottom: 5rem; }
        }

        /* ── Back to Top button ─────────────────────── */
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
            transition: transform 0.25s var(--g-ease-spring), box-shadow 0.25s, background 0.2s;
        }
        #g-back-top.visible {
            display: flex;
            animation: backTopAppear 0.35s var(--g-ease-spring) both;
        }
        #g-back-top:hover {
            background: #e8bc52;
            transform: translateY(-4px) scale(1.08);
            box-shadow: 0 8px 28px rgba(255,211,105,0.5);
        }
        #g-back-top:active { transform: scale(0.92); }
        @media (max-width: 768px) {
            #g-back-top { bottom: 5.5rem; right: 1rem; width: 40px; height: 40px; }
        }

        /* ── Alerts ─────────────────────────────────── */
        .g-alert-success {
            background: rgba(74, 222, 128, 0.08);
            border: 1px solid rgba(74, 222, 128, 0.25);
            color: #86efac;
            border-radius: var(--g-radius-lg);
            padding: 0.85rem 1.25rem;
        }

        /* ── Spinner ────────────────────────────────── */
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
<body class="g-has-sticky">

    <!-- ██ HEADER ████████████████████████████████████████ -->
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
            <button type="button" class="g-icon-btn" id="gFilterOpen" aria-label="Filters">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M4 6h16M4 12h10M4 18h6"/></svg>
            </button>
            <div class="g-cart-wrap">
                <button type="button" class="g-icon-btn" id="gCartOpen" aria-label="Cart">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                    <span class="g-cart-badge" id="gCartBadge" style="display:none;">0</span>
                </button>
            </div>
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

    <!-- ██ MOBILE MENU ████████████████████████████████████ -->
    <div class="g-mobile-overlay" id="gMobileOverlay"></div>
    <div class="g-mobile-menu" id="gMobileMenu">
        <div class="g-mobile-menu-logo">Grow<span>zio</span></div>
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('home') }}">Products</a>
        <div class="g-filter-sect">Categories</div>
        @if($categories->isNotEmpty())
            @foreach($categories->take(8) as $cat)
                <a href="{{ route('products.byCategory', $cat) }}">{{ $cat->name }}</a>
            @endforeach
        @endif
    </div>

    <!-- ██ FILTER DRAWER ██████████████████████████████████ -->
    <div class="g-filter-overlay" id="gFilterOverlay"></div>
    <div class="g-filter-drawer" id="gFilterDrawer">
        <div class="g-filter-header">Filters</div>
        <div class="g-filter-body">
            <p class="g-section-sub mb-3" style="font-size:12px;font-family:var(--font-mono);text-transform:uppercase;letter-spacing:0.1em;color:var(--g-accent);">Shop by category</p>
            @if($categories->isNotEmpty())
                <ul class="g-category-list">
                    @foreach($categories as $cat)
                        <li class="g-category-item">
                            <div class="g-category-row">
                                <span class="g-category-name">{{ $cat->name }}</span>
                                <a href="{{ route('products.byCategory', $cat) }}" class="g-category-link">View →</a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="g-section-sub">No categories yet.</p>
            @endif
        </div>
    </div>

    <!-- ██ CART DRAWER ████████████████████████████████████ -->
    <div class="g-cart-overlay" id="gCartOverlay"></div>
    <div class="g-cart-drawer" id="gCartDrawer">
        <div class="g-cart-header">
            <span class="g-cart-title">Cart</span>
            <button type="button" class="g-cart-close-btn" id="gCartClose" aria-label="Close cart">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>
        <div class="g-cart-body" id="gCartBody">
            <div class="g-cart-empty">Loading cart…</div>
        </div>
        <div class="g-cart-footer" id="gCartFooter" style="display:none;">
            <div class="g-cart-subtotal" id="gCartSubtotal">₹0.00</div>
            <div class="g-cart-actions">
                <a href="{{ route('cart.view') }}" class="g-btn">View cart</a>
                @auth
                    <a href="{{ route('checkout.form') }}" class="g-btn g-btn-primary">Checkout</a>
                @else
                    <a href="{{ route('checkout.login-required') }}" class="g-btn g-btn-primary">Checkout</a>
                @endauth
            </div>
        </div>
    </div>

    <!-- ██ BACK TO TOP ████████████████████████████████████ -->
    <button id="g-back-top" aria-label="Back to top" title="Back to top">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 15l-6-6-6 6"/></svg>
    </button>

    <!-- ██ MAIN ███████████████████████████████████████████ -->
    <main class="g-main">

        @if (session('status'))
            <div class="g-container g-section" style="padding-bottom:0;">
                <div class="g-alert-success">
                    {{ session('status') }}
                </div>
            </div>
        @endif

        <!-- Hero band -->
        <section class="g-hero-band">
            <div class="g-container">
                <div class="g-hero-eyebrow">// Growzio Store</div>
                <h1 class="g-hero-title">
                    @if(isset($searchQuery))
                        Results for <span>"{{ $searchQuery }}"</span>
                    @elseif(isset($category))
                        {{ $category->name }}
                    @else
                        Explore our <span>Collection</span>
                    @endif
                </h1>

                <div class="g-hero-search" role="search">
                    <div class="g-search-input-wrap">
                        <form action="{{ route('search.results') }}" method="GET" id="gSearchForm">
                            <input
                                type="search"
                                name="q"
                                class="g-search-input"
                                id="gSearchInput"
                                placeholder="Search products..."
                                autocomplete="off"
                                value="{{ $searchQuery ?? '' }}"
                            >
                        </form>
                    </div>
                    <div class="g-hero-suggestions" id="gSearchSuggestions"></div>
                </div>

                @if(isset($searchQuery) || isset($category))
                    <p class="g-hero-sub">
                        @if(isset($searchQuery))
                            {{ $products->total() }} product(s) found
                        @else
                            Browse the complete {{ strtolower($category->name) }} range
                        @endif
                    </p>
                @endif
                <div class="g-accent-line"></div>
            </div>
        </section>

        <!-- Categories -->
        @if(!isset($searchQuery))
        <section class="g-section g-categories-section g-reveal">
            <div class="g-container">
                <details class="g-category-dropdown" @if(!isset($category) || (isset($category) && ($categoryProductCount ?? 0) === 0)) open @endif>
                    <summary>
                        <span>@if(isset($category)){{ $category->name }} &mdash; subcategories @else Shop by category @endif</span>
                        <svg class="g-chev" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="m6 9 6 6 6-6"/></svg>
                    </summary>
                    <div class="g-category-dropdown-body">
                        <ul class="g-category-list">
                            @if($categories->isNotEmpty())
                                @include('products.categories._tree_unity', ['categories' => $categories])
                            @else
                                <li class="g-category-row"><span class="g-section-sub">No categories.</span></li>
                            @endif
                        </ul>
                    </div>
                </details>
            </div>
        </section>
        @endif

        <!-- Products -->
        @if(!isset($category) || isset($searchQuery) || (isset($category) && ($categoryProductCount ?? 0) > 0))
        <section class="g-section g-products-section">
            <div class="g-container">
                <div class="g-section-head g-reveal">
                    @if(isset($category) && $category->image_path)
                        <img src="{{ asset($category->image_path) }}" alt="{{ $category->name }}"
                            style="max-width:100px;margin-bottom:1rem;border-radius:var(--g-radius-lg);opacity:0.85;">
                    @endif
                    <div class="g-section-eyebrow">// Products</div>
                    <h2 class="g-section-title">
                        @if(isset($searchQuery)) "{{ $searchQuery }}"
                        @elseif(isset($category)) {{ $category->name }}
                        @else Our Products
                        @endif
                    </h2>
                    <p class="g-section-sub">
                        @if(isset($searchQuery)) {{ $products->total() }} result(s) found
                        @elseif(isset($category)) Explore our {{ strtolower($category->name) }} collection
                        @else Explore everything we carry
                        @endif
                    </p>
                    @if ($products->count() > 0)
                        @php
                            $baseSortParams = isset($searchQuery) ? array_filter(request()->only(['q'])) : request()->except('sort');
                            $baseSortUrl = request()->url() . (count($baseSortParams) ? '?' . http_build_query($baseSortParams) : '');
                            $sortPriceAsc   = $baseSortUrl . (str_contains($baseSortUrl, '?') ? '&' : '?') . 'sort=price_asc';
                            $sortPriceDesc  = $baseSortUrl . (str_contains($baseSortUrl, '?') ? '&' : '?') . 'sort=price_desc';
                            $sortBestSellers = $baseSortUrl . (str_contains($baseSortUrl, '?') ? '&' : '?') . 'sort=best_sellers';
                        @endphp
                        <div class="g-sort-wrap">
                            <label for="sort-by-select" class="g-sort-label">sort:</label>
                            <select id="sort-by-select" class="g-sort-select" aria-label="Sort products">
                                <option value="{{ $baseSortUrl }}"     {{ !isset($sort) || $sort === null ? 'selected' : '' }}>Newest</option>
                                <option value="{{ $sortPriceAsc }}"    {{ (isset($sort) && $sort === 'price_asc')    ? 'selected' : '' }}>Price: Low → High</option>
                                <option value="{{ $sortPriceDesc }}"   {{ (isset($sort) && $sort === 'price_desc')   ? 'selected' : '' }}>Price: High → Low</option>
                                <option value="{{ $sortBestSellers }}" {{ (isset($sort) && $sort === 'best_sellers') ? 'selected' : '' }}>Best Sellers</option>
                            </select>
                        </div>
                    @endif
                </div>

                @if ($products->count())
                    @php
                        $nextUrl = $products->nextPageUrl();
                        $nextUrlRelative = $nextUrl
                            ? parse_url($nextUrl, PHP_URL_PATH) . (parse_url($nextUrl, PHP_URL_QUERY) ? '?' . parse_url($nextUrl, PHP_URL_QUERY) : '')
                            : '';
                    @endphp
                    <div id="products-infinite-container"
                        data-next-url="{{ $nextUrlRelative }}"
                        data-has-more="{{ $products->hasMorePages() ? '1' : '0' }}"
                        data-csrf="{{ csrf_token() }}">
                        <div id="products-grid-row" class="row g-3 g-md-4">
                            @foreach ($products as $product)
                                @include('products._card', ['product' => $product])
                            @endforeach
                        </div>
                        <div id="products-infinite-sentinel" aria-hidden="true"></div>
                        <div id="products-infinite-loading" class="text-center py-4 d-none">
                            <span class="g-spinner"></span>
                            <p class="g-section-sub mt-2">Loading more…</p>
                        </div>
                        <div id="products-infinite-end" class="text-center py-4 d-none">
                            <p class="g-section-sub">— You've seen everything —</p>
                        </div>
                        <div id="products-infinite-error" class="text-center py-4 d-none">
                            <p class="g-section-sub">Failed to load. <button type="button" class="g-btn" style="font-size:13px;padding:0.35rem 0.75rem;" id="products-infinite-retry">Retry</button></p>
                        </div>
                    </div>
                @else
                    <div class="no-products g-reveal">
                        <h3>@if(isset($searchQuery)) No results found @else No products yet @endif</h3>
                        <p class="g-section-sub mt-1">@if(isset($searchQuery)) Try a different keyword. @else Check back soon. @endif</p>
                        @if(isset($searchQuery))
                            <a href="{{ route('home') }}" class="g-btn g-btn-primary mt-4">View all products</a>
                        @endif
                    </div>
                @endif
            </div>
        </section>
        @endif
    </main>

    <!-- ██ STICKY BOTTOM (MOBILE) █████████████████████████ -->
    <div class="g-sticky-bottom">
        <a href="{{ route('cart.view') }}" class="g-sticky-cart">View Cart</a>
        @auth
            <a href="{{ route('checkout.form') }}" class="g-sticky-checkout">Checkout</a>
        @else
            <a href="{{ route('checkout.login-required') }}" class="g-sticky-checkout">Checkout</a>
        @endauth
    </div>

    <!-- ██ SCRIPTS ████████████████████████████████████████ -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    (function () {
        var ease = 'cubic-bezier(0.4,0,0.2,1)';

        /* ─── Sticky header ─────────────────────────────── */
        var header = document.getElementById('gHeader');
        if (header) {
            window.addEventListener('scroll', function () {
                header.classList.toggle('scrolled', window.scrollY > 10);
            }, { passive: true });
        }

        /* ─── Back to Top ───────────────────────────────── */
        var backTopBtn = document.getElementById('g-back-top');
        if (backTopBtn) {
            window.addEventListener('scroll', function () {
                if (window.scrollY > 320) {
                    backTopBtn.classList.add('visible');
                } else {
                    backTopBtn.classList.remove('visible');
                }
            }, { passive: true });
            backTopBtn.addEventListener('click', function () {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }

        /* ─── Mobile menu ───────────────────────────────── */
        var hamburger   = document.getElementById('gHamburger');
        var mobileMenu  = document.getElementById('gMobileMenu');
        var mobileOvly  = document.getElementById('gMobileOverlay');
        function openMobile()  { mobileMenu.classList.add('open'); mobileOvly.classList.add('open'); document.body.style.overflow = 'hidden'; }
        function closeMobile() { mobileMenu.classList.remove('open'); mobileOvly.classList.remove('open'); document.body.style.overflow = ''; }
        if (hamburger) hamburger.addEventListener('click', openMobile);
        if (mobileOvly) mobileOvly.addEventListener('click', closeMobile);

        /* ─── Filter drawer ─────────────────────────────── */
        var filterOpen  = document.getElementById('gFilterOpen');
        var filterDrw   = document.getElementById('gFilterDrawer');
        var filterOvly  = document.getElementById('gFilterOverlay');
        if (filterOpen) filterOpen.addEventListener('click', function () { filterDrw.classList.add('open'); filterOvly.classList.add('open'); document.body.style.overflow = 'hidden'; });
        if (filterOvly) filterOvly.addEventListener('click', function () { filterDrw.classList.remove('open'); filterOvly.classList.remove('open'); document.body.style.overflow = ''; });

        /* ─── Cart drawer ───────────────────────────────── */
        var cartOpen    = document.getElementById('gCartOpen');
        var cartDrw     = document.getElementById('gCartDrawer');
        var cartOvly    = document.getElementById('gCartOverlay');
        var cartClose   = document.getElementById('gCartClose');
        var cartBody    = document.getElementById('gCartBody');
        var cartFooter  = document.getElementById('gCartFooter');
        var cartSubtotal = document.getElementById('gCartSubtotal');
        var cartBadge   = document.getElementById('gCartBadge');
        var drawerUrl   = '{{ route("cart.drawer") }}';

        function loadCartDrawer() {
            fetch(drawerUrl, { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    if (cartBadge) {
                        cartBadge.textContent = data.count;
                        cartBadge.style.display = data.count > 0 ? 'flex' : 'none';
                    }
                    if (data.items.length === 0) {
                        cartBody.innerHTML = '<div class="g-cart-empty">Your cart is empty.</div>';
                        if (cartFooter) cartFooter.style.display = 'none';
                    } else {
                        var csrf = '{{ csrf_token() }}';
                        var html = data.items.map(function (item) {
                            var img = item.image_path
                                ? '<img src="' + escAttr(item.image_path) + '" alt="">'
                                : '<div style="width:64px;height:80px;background:var(--g-bg);border-radius:var(--g-radius);"></div>';
                            var remove = data.authenticated
                                ? '<form method="POST" action="' + escAttr(item.remove_url) + '" class="g-cart-remove-form mt-2"><input type="hidden" name="_token" value="' + escAttr(csrf) + '"><input type="hidden" name="_method" value="DELETE"><button type="submit" class="g-btn" style="padding:0.25rem 0.65rem;font-size:12px;">Remove</button></form>'
                                : '';
                            return '<div class="g-cart-item"><a href="' + escAttr(item.show_url) + '">' + img + '</a>'
                                + '<div class="g-cart-item-info">'
                                + '<a href="' + escAttr(item.show_url) + '" class="g-cart-item-name">' + escHtml(item.name) + '</a>'
                                + '<div class="g-cart-item-meta">Qty ' + item.quantity + ' · ₹' + parseFloat(item.subtotal).toFixed(2) + '</div>'
                                + remove + '</div></div>';
                        }).join('');
                        cartBody.innerHTML = html;
                        if (cartFooter) cartFooter.style.display = 'block';
                        if (cartSubtotal) cartSubtotal.textContent = '₹' + parseFloat(data.subtotal).toFixed(2);
                        cartBody.querySelectorAll('form.g-cart-remove-form').forEach(function (f) {
                            f.addEventListener('submit', function (e) {
                                e.preventDefault();
                                var fd = new FormData(this);
                                fetch(this.action, { method: 'POST', headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }, body: fd })
                                    .then(function () { loadCartDrawer(); });
                            });
                        });
                    }
                })
                .catch(function () {
                    cartBody.innerHTML = '<div class="g-cart-empty">Could not load cart.</div>';
                    if (cartFooter) cartFooter.style.display = 'none';
                });
        }

        function escHtml(s) { if (!s) return ''; var d = document.createElement('div'); d.textContent = s; return d.innerHTML; }
        function escAttr(s) { return escHtml(s).replace(/"/g, '&quot;'); }

        if (cartOpen)  cartOpen.addEventListener('click',  function () { cartDrw.classList.add('open'); cartOvly.classList.add('open'); document.body.style.overflow = 'hidden'; loadCartDrawer(); });
        if (cartClose) cartClose.addEventListener('click', function () { cartDrw.classList.remove('open'); cartOvly.classList.remove('open'); document.body.style.overflow = ''; });
        if (cartOvly)  cartOvly.addEventListener('click',  function () { cartDrw.classList.remove('open'); cartOvly.classList.remove('open'); document.body.style.overflow = ''; });
        loadCartDrawer();

        /* ─── Reveal on scroll ──────────────────────────── */
        var reveals = document.querySelectorAll('.g-reveal');
        var revObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('g-revealed');
                    revObserver.unobserve(entry.target);
                }
            });
        }, { rootMargin: '0px 0px -50px 0px', threshold: 0.08 });
        reveals.forEach(function (el) { revObserver.observe(el); });

        window.gLoadCartDrawer = loadCartDrawer;
    })();
    </script>

    <script>
    /* ─── Search autocomplete ───────────────────────────── */
    (function () {
        function escHtml(s) { if (!s) return ''; var d = document.createElement('div'); d.textContent = s; return d.innerHTML; }
        function escAttr(s) { return escHtml(s).replace(/"/g, '&quot;'); }
        var input       = document.getElementById('gSearchInput');
        var suggestEl   = document.getElementById('gSearchSuggestions');
        var suggestUrl  = '{{ route("search.suggestions") }}';
        var debounce    = null;
        if (!input || !suggestEl) return;
        input.addEventListener('input', function () {
            var q = input.value.trim();
            clearTimeout(debounce);
            if (!q) { suggestEl.innerHTML = ''; return; }
            debounce = setTimeout(function () {
                fetch(suggestUrl + '?q=' + encodeURIComponent(q), { headers: { 'Accept': 'application/json' } })
                    .then(function (r) { return r.json(); })
                    .then(function (res) {
                        var data = res.data || [];
                        if (data.length === 0) {
                            suggestEl.innerHTML = '<div class="g-suggestion-item" style="pointer-events:none;color:var(--g-text-muted);">No suggestions found</div>';
                        } else {
                            var viewAllUrl = '{{ route("search.results") }}?q=' + encodeURIComponent(q);
                            suggestEl.innerHTML = data.map(function (p) {
                                var img = p.image_path ? '<img src="' + escAttr(p.image_path) + '" alt="">' : '<div style="width:48px;height:48px;background:var(--g-bg2);border-radius:var(--g-radius);flex-shrink:0;"></div>';
                                return '<a href="' + escAttr(p.show_url || '#') + '" class="g-suggestion-item">'
                                    + '<div style="flex-shrink:0;">' + img + '</div>'
                                    + '<div><div style="font-size:14px;font-weight:500;">' + escHtml(p.name || '') + '</div>'
                                    + '<span class="price">₹' + escHtml(p.price || '') + '</span></div></a>';
                            }).join('')
                            + '<a href="' + viewAllUrl + '" class="g-suggestion-item" style="justify-content:center;color:var(--g-accent);font-weight:600;border-top:1px solid var(--g-border);margin-top:0.5rem;padding-top:1rem;">View all results →</a>';
                        }
                    });
            }, 300);
        });
    })();

    /* ─── Toast ─────────────────────────────────────────── */
    function showCartToast() {
        var existing = document.getElementById('g-toast');
        if (existing) existing.remove();
        var toast = document.createElement('div');
        toast.id = 'g-toast';
        toast.className = 'g-toast';
        toast.innerHTML = '<span class="g-toast-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg></span> Added to cart';
        document.body.appendChild(toast);
        setTimeout(function () { if (toast.parentNode) toast.remove(); }, 2800);
        if (window.gLoadCartDrawer) window.gLoadCartDrawer();
    }

    /* ─── Ajax add-to-cart ──────────────────────────────── */
    function submitCartFormAjax(form, button) {
        var origHtml = button ? button.innerHTML : '';
        if (button) {
            button.innerHTML = '<span class="g-spinner"></span>';
            button.disabled = true;
        }
        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(function (r) { return r.json(); })
        .then(function () { showCartToast(); if (button) { button.innerHTML = origHtml; button.disabled = false; } })
        .catch(function () { if (button) { button.innerHTML = origHtml; button.disabled = false; } showCartToast(); });
    }

    document.addEventListener('DOMContentLoaded', function () {

        /* Bind cart forms */
        document.querySelectorAll('form[action*="/cart/"]').forEach(function (form) {
            if (form.dataset.bound) return;
            form.dataset.bound = '1';
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                submitCartFormAjax(this, this.querySelector('button[type="submit"]'));
            });
        });

        /* Sort select */
        var sortSelect = document.getElementById('sort-by-select');
        if (sortSelect) sortSelect.addEventListener('change', function () { if (this.value) window.location.href = this.value; });

        /* ─── Infinite scroll ───────────────────────────── */
        var container = document.getElementById('products-infinite-container');
        if (container) {
            var gridRow    = document.getElementById('products-grid-row');
            var sentinel   = document.getElementById('products-infinite-sentinel');
            var loadingEl  = document.getElementById('products-infinite-loading');
            var endEl      = document.getElementById('products-infinite-end');
            var errorEl    = document.getElementById('products-infinite-error');
            var retryBtn   = document.getElementById('products-infinite-retry');
            var nextUrl    = container.getAttribute('data-next-url') || '';
            var hasMore    = container.getAttribute('data-has-more') === '1';
            var csrf       = container.getAttribute('data-csrf') || '';
            var loading    = false;

            function buildCard(p) {
                var img = p.image_path
                    ? '<img src="' + (p.image_path.replace(/"/g, '&quot;')) + '" alt="">'
                    : '<div class="g-product-image-placeholder"><svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg></div>';
                var name    = (p.name || '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
                var cat     = (p.category_name || '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
                var partNo  = (p.company_part_number || '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
                var meta    = (cat || partNo) ? '<div class="g-product-meta"><span class="g-product-category">' + cat + '</span><span class="g-product-partno">' + partNo + '</span></div>' : '';
                return '<div class="col-6 col-md-4 col-lg-3 g-product-col">'
                    + '<div class="g-product-card">'
                    + '<a href="' + (p.show_url || '#').replace(/"/g,'&quot;') + '" class="g-product-link">'
                    + '<div class="g-product-image">' + img + '</div>'
                    + '<div class="g-product-details">'
                    + '<span class="g-product-name">' + name + '</span>'
                    + '<span class="g-product-price">₹' + (p.price || '') + '</span>'
                    + meta
                    + '</div></a>'
                    + '<div class="g-product-actions">'
                    + '<form method="POST" action="' + (p.add_to_cart_url || '').replace(/"/g,'&quot;') + '" class="g-add-form">'
                    + '<input type="hidden" name="_token" value="' + csrf + '">'
                    + '<input type="hidden" name="quantity" value="1">'
                    + '<button type="submit" class="g-btn-add">'
                    + '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>'
                    + 'Add to Cart</button></form></div></div></div>';
            }

            var infObserver = new IntersectionObserver(function (entries) {
                if (!entries[0].isIntersecting || loading || !hasMore || !nextUrl) return;
                loading = true;
                if (loadingEl) loadingEl.classList.remove('d-none');
                fetch(nextUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
                    .then(function (r) { return r.json(); })
                    .then(function (json) {
                        loading = false;
                        if (loadingEl) loadingEl.classList.add('d-none');
                        if (json.data && json.data.length) {
                            json.data.forEach(function (p) {
                                var div = document.createElement('div');
                                div.innerHTML = buildCard(p);
                                var card = div.firstChild;
                                card.style.opacity = '0';
                                card.style.transform = 'translateY(24px)';
                                gridRow.appendChild(card);
                                requestAnimationFrame(function () {
                                    card.style.transition = 'opacity 0.45s ease, transform 0.45s ease';
                                    card.style.opacity = '1';
                                    card.style.transform = 'translateY(0)';
                                });
                            });
                            document.querySelectorAll('#products-grid-row form[action*="/cart/"]').forEach(function (form) {
                                if (form.dataset.bound) return;
                                form.dataset.bound = '1';
                                form.addEventListener('submit', function (e) { e.preventDefault(); submitCartFormAjax(this, this.querySelector('button')); });
                            });
                        }
                        nextUrl = json.next_page_url || '';
                        hasMore = !!json.has_more_pages;
                        container.setAttribute('data-next-url', nextUrl);
                        container.setAttribute('data-has-more', hasMore ? '1' : '0');
                        if (!hasMore && endEl) endEl.classList.remove('d-none');
                    })
                    .catch(function () { loading = false; if (loadingEl) loadingEl.classList.add('d-none'); if (errorEl) errorEl.classList.remove('d-none'); });
            }, { rootMargin: '200px 0px', threshold: 0 });

            if (sentinel) infObserver.observe(sentinel);
            if (retryBtn) retryBtn.addEventListener('click', function () {
                errorEl.classList.add('d-none');
                if (nextUrl) { loading = false; infObserver.unobserve(sentinel); infObserver.observe(sentinel); }
            });
        }

        /* ─── Category toggle ───────────────────────────── */
        function toggleUnityCategory(categoryId) {
            var childrenList = document.getElementById('unity-children-' + categoryId);
            var icon = document.getElementById('unity-icon-' + categoryId);
            if (childrenList && icon) {
                var isHidden = childrenList.classList.contains('hidden') || childrenList.hidden === true;
                // Expand
                if (isHidden) {
                    childrenList.classList.remove('hidden');
                    childrenList.hidden = false;
                    icon.textContent = '▼';
                } else {
                    // Collapse
                    childrenList.classList.add('hidden');
                    childrenList.hidden = true;
                    icon.textContent = '▶';
                }
            }
        }
        window.toggleUnityCategory = toggleUnityCategory;
    });
    </script>

</body>
</html>
