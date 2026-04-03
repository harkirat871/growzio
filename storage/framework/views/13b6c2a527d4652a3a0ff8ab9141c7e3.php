<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products -</title>
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
            <a href="<?php echo e(route('home')); ?>" class="unity-logo">Make Your Order</a>
            <nav class="unity-nav-desktop">
                <a href="<?php echo e(route('home')); ?>" class="<?php echo e(request()->routeIs('home') ? 'active' : ''); ?>">Home</a>
                <a href="<?php echo e(route('home')); ?>">Products</a>
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
                        <li>
                            <form method="POST" action="<?php echo e(route('logout')); ?>"><?php echo csrf_field(); ?>
                                <button type="submit" class="dropdown-item w-100 text-start">Log Out</button>
                            </form>
                        </li>
                    </ul>
                </div>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" class="unity-btn" style="padding: 0.4rem 0.75rem; font-size: 13px;">Login</a>
                <a href="<?php echo e(route('register')); ?>" class="unity-btn unity-btn-primary" style="padding: 0.4rem 0.75rem; font-size: 13px;">Register</a>
            <?php endif; ?>
        </div>
    </header>

    <!-- Mobile menu (slide from left) -->
    <div class="unity-mobile-menu-overlay" id="unityMobileOverlay"></div>
    <div class="unity-mobile-menu" id="unityMobileMenu">
        <a href="<?php echo e(route('home')); ?>">Home</a>
        <a href="<?php echo e(route('home')); ?>">Products</a>
        <div class="unity-filter-section">
            <strong>Categories</strong>
        </div>
        <?php if($categories->isNotEmpty()): ?>
            <?php $__currentLoopData = $categories->take(8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('products.byCategory', $cat)); ?>"><?php echo e($cat->name); ?></a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </div>

    <!-- Search overlay -->
    <div class="unity-search-overlay" id="unitySearchOverlay">
        <div class="unity-search-overlay-header">
            <div class="unity-search-overlay-input-wrap">
                <form action="<?php echo e(route('search.results')); ?>" method="GET" id="unitySearchForm" role="search">
                    <input type="search" name="q" class="unity-search-overlay-input" id="unitySearchInput" placeholder="Search products..." autocomplete="off" value="<?php echo e($searchQuery ?? ''); ?>">
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
            <?php if($categories->isNotEmpty()): ?>
                <ul class="unity-category-list">
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="unity-category-item">
                            <div class="unity-category-row">
                                <span class="unity-category-name"><?php echo e($cat->name); ?></span>
                                <a href="<?php echo e(route('products.byCategory', $cat)); ?>" class="unity-category-link">View</a>
                            </div>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php else: ?>
                <p class="unity-section-subtitle">No categories.</p>
            <?php endif; ?>
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
                <a href="<?php echo e(route('cart.view')); ?>" class="unity-btn">View cart</a>
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('checkout.form')); ?>" class="unity-btn unity-btn-primary">Checkout</a>
                <?php else: ?>
                    <a href="<?php echo e(route('checkout.login-required')); ?>" class="unity-btn unity-btn-primary">Checkout</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <main class="unity-main">
        <?php if(session('status')): ?>
            <div class="unity-container unity-section">
                <div class="alert alert-success alert-dismissible fade show">
                    <?php echo e(session('status')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        <?php endif; ?>

        <?php if(!isset($searchQuery)): ?>
        <section class="unity-section unity-categories unity-reveal">
            <div class="unity-container">
                <details class="unity-category-dropdown" <?php if(!isset($category) || (isset($category) && ($categoryProductCount ?? 0) === 0)): ?> open <?php endif; ?>>
                    <summary>
                        <span><?php if(isset($category)): ?><?php echo e($category->name); ?> categories <?php else: ?> Shop by category <?php endif; ?></span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
                    </summary>
                    <div class="unity-category-dropdown-body">
                        <ul class="unity-category-list">
                            <?php if($categories->isNotEmpty()): ?>
                                <?php echo $__env->make('products.categories._tree_unity', ['categories' => $categories], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            <?php else: ?>
                                <li class="unity-category-row"><span class="unity-section-subtitle">No categories.</span></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </details>
            </div>
        </section>
        <?php endif; ?>

        <?php if(!isset($category) || isset($searchQuery) || (isset($category) && ($categoryProductCount ?? 0) > 0)): ?>
        <section class="unity-section unity-products-section">
            <div class="unity-container">
                <div class="unity-section-title unity-reveal">
                    <?php if(isset($category) && $category->image_path): ?>
                        <img src="<?php echo e(asset($category->image_path)); ?>" alt="<?php echo e($category->name); ?>" style="max-width:120px;margin-bottom:1rem;">
                    <?php endif; ?>
                    <h2>
                        <?php if(isset($searchQuery)): ?> Search results for "<?php echo e($searchQuery); ?>"
                        <?php elseif(isset($category)): ?> <?php echo e($category->name); ?> Products
                        <?php else: ?> Our Products
                        <?php endif; ?>
                    </h2>
                    <p class="unity-section-subtitle">
                        <?php if(isset($searchQuery)): ?> <?php echo e($products->total()); ?> product(s) found
                        <?php elseif(isset($category)): ?> Explore our <?php echo e(strtolower($category->name )); ?> collection
                        <?php else: ?> Explore our collection
                        <?php endif; ?>
                    </p>
                    <?php if($products->count() > 0): ?>
                        <?php
                            $baseSortParams = isset($searchQuery) ? array_filter(request()->only(['q'])) : request()->except('sort');
                            $baseSortUrl = request()->url() . (count($baseSortParams) ? '?' . http_build_query($baseSortParams) : '');
                            $sortPriceAsc = $baseSortUrl . (str_contains($baseSortUrl, '?') ? '&' : '?') . 'sort=price_asc';
                            $sortPriceDesc = $baseSortUrl . (str_contains($baseSortUrl, '?') ? '&' : '?') . 'sort=price_desc';
                            $sortBestSellers = $baseSortUrl . (str_contains($baseSortUrl, '?') ? '&' : '?') . 'sort=best_sellers';
                        ?>
                        <div class="unity-sort-wrap">
                            <label for="sort-by-select" class="unity-section-subtitle mb-0">Sort</label>
                            <select id="sort-by-select" class="unity-sort-select" aria-label="Sort products">
                                <option value="<?php echo e($baseSortUrl); ?>" <?php echo e(!isset($sort) || $sort === null ? 'selected' : ''); ?>>Newest</option>
                                <option value="<?php echo e($sortPriceAsc); ?>" <?php echo e((isset($sort) && $sort === 'price_asc') ? 'selected' : ''); ?>>Price: Low to High</option>
                                <option value="<?php echo e($sortPriceDesc); ?>" <?php echo e((isset($sort) && $sort === 'price_desc') ? 'selected' : ''); ?>>Price: High to Low</option>
                                <option value="<?php echo e($sortBestSellers); ?>" <?php echo e((isset($sort) && $sort === 'best_sellers') ? 'selected' : ''); ?>>Best Sellers</option>
                            </select>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if($products->count()): ?>
                    <?php
                        $nextUrl = $products->nextPageUrl();
                        $nextUrlRelative = $nextUrl ? parse_url($nextUrl, PHP_URL_PATH) . (parse_url($nextUrl, PHP_URL_QUERY) ? '?' . parse_url($nextUrl, PHP_URL_QUERY) : '') : '';
                    ?>
                    <div id="products-infinite-container" data-next-url="<?php echo e($nextUrlRelative); ?>" data-has-more="<?php echo e($products->hasMorePages() ? '1' : '0'); ?>" data-csrf="<?php echo e(csrf_token()); ?>">
                        <div id="products-grid-row" class="row g-3 g-md-4">
                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php echo $__env->make('products._card', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                <?php else: ?>
                    <div class="no-products unity-reveal">
                        <h3 style="font-weight:600;letter-spacing:-0.02em;margin-bottom:0.5rem;"><?php if(isset($searchQuery)): ?> No results <?php else: ?> No products yet <?php endif; ?></h3>
                        <p class="unity-section-subtitle"><?php if(isset($searchQuery)): ?> Try a different search. <?php else: ?> Check back soon. <?php endif; ?></p>
                        <?php if(isset($searchQuery)): ?>
                            <a href="<?php echo e(route('home')); ?>" class="unity-btn mt-3">View all</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <?php endif; ?>
    </main>

    <div class="unity-sticky-bottom">
        <a href="<?php echo e(route('cart.view')); ?>" class="sticky-cart">View Cart</a>
        <?php if(auth()->guard()->check()): ?>
            <a href="<?php echo e(route('checkout.form')); ?>" class="sticky-checkout">Checkout</a>
        <?php else: ?>
            <a href="<?php echo e(route('checkout.login-required')); ?>" class="sticky-checkout">Checkout</a>
        <?php endif; ?>
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
            var drawerUrl = '<?php echo e(route("cart.drawer")); ?>';

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
                            var csrf = '<?php echo e(csrf_token()); ?>';
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
            var suggestionsUrl = '<?php echo e(route("search.suggestions")); ?>';
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
                                var viewAllUrl = '<?php echo e(route("search.results")); ?>?q=' + encodeURIComponent(q);
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
</html>
<?php /**PATH C:\Users\Admin\clean\complete ecom before mass upload - Copy\resources\views/products/index.blade.php ENDPATH**/ ?>