
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Growzio </title>
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

        /* ── Slides carousel ─────────────────────────── */
        .g-slides-section { background: var(--g-bg); }
        .g-slides-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        .g-slides-title {
            font-family: var(--font-head);
            font-weight: 700;
            letter-spacing: -0.02em;
            color: var(--g-light);
            font-size: 1.1rem;
            margin: 0;
        }
        .g-slides-actions { display: flex; align-items: center; gap: 0.5rem; }
        .g-slides-btn {
            width: 38px; height: 38px;
            border-radius: var(--g-radius);
            border: 1px solid var(--g-border);
            background: var(--g-bg2);
            color: var(--g-text);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: border-color 0.2s, transform 0.2s, color 0.2s;
        }
        .g-slides-btn:hover { border-color: var(--g-border-hover); color: var(--g-accent); transform: translateY(-1px); }
        .g-slides-fullscreen {
            border-radius: var(--g-radius);
            border: 1px solid var(--g-border);
            background: var(--g-bg2);
            color: var(--g-text);
            padding: 0 0.85rem;
            height: 38px;
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;
        }
        .g-slides-fullscreen:hover { border-color: var(--g-border-hover); color: var(--g-accent); }

        .g-slides-viewport {
            position: relative;
            overflow: hidden;
            border-radius: var(--g-radius-lg);
            border: 1px solid var(--g-border);
            background: rgba(57,62,70,0.35);
        }
        .g-slides-track {
            display: flex;
            gap: 12px;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            scroll-behavior: smooth;
            padding: 14px;
            -webkit-overflow-scrolling: touch;
        }
        .g-slides-track::-webkit-scrollbar { height: 8px; }
        .g-slides-track::-webkit-scrollbar-thumb { background: rgba(255,211,105,0.45); border-radius: 8px; }

        .g-slide-card {
            flex: 0 0 auto;
            width: 220px;
            scroll-snap-align: start;
            background: rgba(34,40,49,0.65);
            border: 1px solid var(--g-border);
            border-radius: var(--g-radius-lg);
            overflow: hidden;
        }
        .g-slide-card img {
            width: 100%;
            height: auto;
            display: block;
        }
        @media (min-width: 992px) {
            .g-slide-card { width: 240px; }
        }
        @media (max-width: 767.98px) {
            .g-slides-track { padding: 12px; gap: 10px; }
            .g-slide-card {
                width: min(84vw, 360px);
                scroll-snap-align: center;
            }
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

        /* Cart link: desktop-only (mobile uses sticky bottom) */
        .g-cart-link { display: none; }
        @media (min-width: 769px) {
            .g-cart-link { display: inline-flex; }
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
                {{-- <a href="{{ route('home') }}" class="active">Products</a> --}}
            </nav>
        </div>
        <div class="g-header-right">
            <button type="button" class="g-icon-btn" id="gFilterOpen" aria-label="Filters">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M4 6h16M4 12h10M4 18h6"/></svg>
            </button>
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

    <!-- ██ BACK TO TOP ████████████████████████████████████ -->
    <button id="g-back-top" aria-label="Back to top" title="Back to top">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 15l-6-6-6 6"/></svg>
    </button>

    <!-- ██ MAIN ███████████████████████████████████████████ -->
    <main class="g-main">
        @include('partials.toast')

      {{-- ═══════════════════════════════════════════
         HERO BAND
    ═══════════════════════════════════════════ --}}
    <section class="g-hero-band">
        <div class="g-container">

            <div class="g-hero-eyebrow">// Growzio</div>

            <h1 class="g-hero-title">
                @if(isset($searchQuery))
                    Results for <span>"{{ $searchQuery }}"</span>
                @elseif(isset($category))
                    {{ $category->name }}
                @else
                    Explore our <span>Collection</span>
                @endif
            </h1>

            @if(isset($searchQuery))
                <p class="g-hero-meta">{{ $products->total() }} product(s) found</p>
            @elseif(isset($category))
                <p class="g-hero-meta">Browse the complete {{ strtolower($category->name) }} range</p>
            @endif

            <div class="g-hero-search" role="search">
                <form action="{{ route('search.results') }}" method="GET" id="gSearchForm" class="g-search-form">
                    <div class="g-search-input-wrap">
                        <svg class="g-search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true">
                            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                        </svg>
                        <input
                            type="search"
                            name="q"
                            class="g-search-input"
                            id="gSearchInput"
                            placeholder="Search products…"
                            autocomplete="off"
                            value="{{ $searchQuery ?? '' }}"
                            aria-label="Search products"
                        >
                        @if(isset($searchQuery))
                            <a href="{{ route('home') }}" class="g-search-clear" aria-label="Clear search">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M18 6 6 18M6 6l12 12"/></svg>
                            </a>
                        @endif
                    </div>
                </form>
                <div class="g-hero-suggestions" id="gSearchSuggestions" aria-live="polite"></div>
            </div>

            <div class="g-accent-line"></div>

        </div>
    </section>

    {{-- ═══════════════════════════════════════════
         SLIDES CAROUSEL  (hidden on search)
    ═══════════════════════════════════════════ --}}
    @if(!isset($searchQuery))
    <section class="g-section g-slides-section g-reveal" aria-label="Product catalog slides">
        <div class="g-container">

            <div class="g-section-head g-section-head--row">
                <div>
                    <div class="g-section-eyebrow">// Catalog</div>
                    <h2 class="g-section-title">Browse the deck</h2>
                </div>
                <div class="g-slides-actions">
                    <button type="button" class="g-slides-btn" id="gSlidesPrev" aria-label="Previous slides">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M15 18l-6-6 6-6"/></svg>
                    </button>
                    <button type="button" class="g-slides-btn" id="gSlidesNext" aria-label="Next slides">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M9 18l6-6-6-6"/></svg>
                    </button>
                    <a class="g-slides-fullscreen" href="{{ url('/viewer') }}" target="_blank" rel="noopener" aria-label="Open catalog in fullscreen">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M8 3H5a2 2 0 0 0-2 2v3"/><path d="M16 3h3a2 2 0 0 1 2 2v3"/><path d="M8 21H5a2 2 0 0 1-2-2v-3"/><path d="M16 21h3a2 2 0 0 0 2-2v-3"/></svg>
                        Fullscreen
                    </a>
                </div>
            </div>

            <div class="g-slides-viewport">
                <div class="g-slides-track" id="gSlidesTrack">
                    @for ($i = 1; $i <= 21; $i++)
                        @php $num = str_pad($i, 4, '0', STR_PAD_LEFT); @endphp
                        <div class="g-slide-card">
                            <img
                                src="{{ asset('slides/pdf_pages-to-jpg-' . $num . '.webp') }}"
                                alt="Catalog slide {{ $i }} of 21"
                                loading="lazy"
                                decoding="async"
                                width="800"
                                height="600"
                            >
                        </div>
                    @endfor
                </div>
            </div>

        </div>
    </section>
    @endif

    {{-- ═══════════════════════════════════════════
         CATEGORIES  (hidden on search)
    ═══════════════════════════════════════════ --}}
    @if(!isset($searchQuery))
    <section class="g-section g-categories-section g-reveal">
        <div class="g-container">

            <details class="g-category-dropdown" @if(!isset($category) || ($categoryProductCount ?? 0) === 0) open @endif>
                <summary class="g-category-summary">
                    <div class="g-category-summary-label">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                        <span>
                            @if(isset($category))
                                {{ $category->name }} &mdash; subcategories
                            @else
                                Shop by category
                            @endif
                        </span>
                    </div>
                    <svg class="g-chev" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                </summary>

                <div class="g-category-dropdown-body">
                    @if($categories->isNotEmpty())
                        <ul class="g-category-list">
                            @include('products.categories._tree_unity', ['categories' => $categories])
                        </ul>
                    @else
                        <p class="g-section-sub g-category-empty">No categories available yet.</p>
                    @endif
                </div>
            </details>

        </div>
    </section>
    @endif

    {{-- ═══════════════════════════════════════════
         PRODUCTS GRID
    ═══════════════════════════════════════════ --}}
    @if(!isset($category) || isset($searchQuery) || ($categoryProductCount ?? 0) > 0)
    <section class="g-section g-products-section">
        <div class="g-container">

            {{-- Section header --}}
            <div class="g-section-head g-reveal">

                @if(isset($category) && $category->image_path)
                    <img
                        src="{{ asset($category->image_path) }}"
                        alt="{{ $category->name }}"
                        class="g-category-hero-img"
                    >
                @endif

                <div class="g-section-eyebrow">// Products</div>

                <div class="g-products-head-row">
                    <div>
                        <h2 class="g-section-title">
                            @if(isset($searchQuery))
                                "{{ $searchQuery }}"
                            @elseif(isset($category))
                                {{ $category->name }}
                            @else
                                Our Products
                            @endif
                        </h2>
                        <p class="g-section-sub">
                            @if(isset($searchQuery))
                                {{ $products->total() }} result(s) found
                            @elseif(isset($category))
                                Explore our {{ strtolower($category->name) }} collection
                            @else
                                Explore everything we carry
                            @endif
                        </p>
                    </div>

                    @if($products->count() > 0)
                        @php
                            $baseSortParams = isset($searchQuery)
                                ? array_filter(request()->only(['q']))
                                : request()->except('sort');
                            $baseSortUrl      = request()->url() . (count($baseSortParams) ? '?' . http_build_query($baseSortParams) : '');
                            $sep              = str_contains($baseSortUrl, '?') ? '&' : '?';
                            $sortPriceAsc     = $baseSortUrl . $sep . 'sort=price_asc';
                            $sortPriceDesc    = $baseSortUrl . $sep . 'sort=price_desc';
                            $sortBestSellers  = $baseSortUrl . $sep . 'sort=best_sellers';
                        @endphp
                        <div class="g-sort-wrap">
                            <label for="sort-by-select" class="g-sort-label">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><path d="M3 6h18M7 12h10M11 18h2"/></svg>
                                Sort
                            </label>
                            <select id="sort-by-select" class="g-sort-select" aria-label="Sort products">
                                <option value="{{ $baseSortUrl }}"     {{ !isset($sort) || $sort === null ? 'selected' : '' }}>Newest</option>
                                <option value="{{ $sortPriceAsc }}"    {{ (isset($sort) && $sort === 'price_asc')    ? 'selected' : '' }}>Price: Low → High</option>
                                <option value="{{ $sortPriceDesc }}"   {{ (isset($sort) && $sort === 'price_desc')   ? 'selected' : '' }}>Price: High → Low</option>
                                <option value="{{ $sortBestSellers }}" {{ (isset($sort) && $sort === 'best_sellers') ? 'selected' : '' }}>Best Sellers</option>
                            </select>
                        </div>
                    @endif
                </div>

            </div>{{-- /.g-section-head --}}

            {{-- Products grid or empty state --}}
            @if($products->count())
                @php
                    $nextUrl         = $products->nextPageUrl();
                    $nextUrlRelative = $nextUrl
                        ? parse_url($nextUrl, PHP_URL_PATH) . (parse_url($nextUrl, PHP_URL_QUERY) ? '?' . parse_url($nextUrl, PHP_URL_QUERY) : '')
                        : '';
                @endphp

                <div
                    id="products-infinite-container"
                    data-next-url="{{ $nextUrlRelative }}"
                    data-has-more="{{ $products->hasMorePages() ? '1' : '0' }}"
                    data-csrf="{{ csrf_token() }}"
                >
                    <div id="products-grid-row" class="row g-3 g-md-4">
                        @foreach ($products as $product)
                            @include('products._card', ['product' => $product])
                        @endforeach
                    </div>

                    <div id="products-infinite-sentinel" aria-hidden="true"></div>

                    <div id="products-infinite-loading" class="g-infinite-state d-none" role="status" aria-live="polite">
                        <span class="g-spinner"></span>
                        <p class="g-section-sub">Loading more…</p>
                    </div>

                    <div id="products-infinite-end" class="g-infinite-state d-none" aria-live="polite">
                        <span class="g-infinite-divider"></span>
                        <p class="g-section-sub">You've seen everything</p>
                        <span class="g-infinite-divider"></span>
                    </div>

                    <div id="products-infinite-error" class="g-infinite-state d-none" role="alert">
                        <p class="g-section-sub">Something went wrong loading more products.</p>
                        <button type="button" class="g-btn g-btn-sm" id="products-infinite-retry">Try again</button>
                    </div>
                </div>

            @else
                <div class="g-empty-state g-reveal">
                    <div class="g-empty-state-icon" aria-hidden="true">
                        @if(isset($searchQuery))
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/><path d="M8 11h6M11 8v6" opacity=".4"/></svg>
                        @else
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" opacity=".4"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
                        @endif
                    </div>
                    <h3 class="g-empty-state-title">
                        @if(isset($searchQuery)) No results found @else No products yet @endif
                    </h3>
                    <p class="g-section-sub">
                        @if(isset($searchQuery)) Try a different keyword or browse all products. @else Check back soon — products are on the way. @endif
                    </p>
                    @if(isset($searchQuery))
                        <a href="{{ route('home') }}" class="g-btn g-btn-primary">View all products</a>
                    @endif
                </div>
            @endif

        </div>
    </section>
    @endif

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

        // Cart drawer intentionally removed from index page.

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
    function showCartToast(message, isError) {
        var existing = document.getElementById('g-toast');
        if (existing) existing.remove();
        var toast = document.createElement('div');
        toast.id = 'g-toast';
        toast.className = 'g-toast';
        var icon = isError
            ? '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 9v4"/><path d="M12 17h.01"/><path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/></svg>'
            : '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>';
        var safeMsg = (message || (isError ? 'Could not add to cart' : 'Added to cart'))
            .replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
        toast.innerHTML = '<span class="g-toast-icon" style="' + (isError ? 'color:#f87171;' : '') + '">' + icon + '</span> ' + safeMsg;
        document.body.appendChild(toast);
        setTimeout(function () { if (toast.parentNode) toast.remove(); }, 2800);
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
            credentials: 'same-origin',
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(function (r) {
            var ct = (r.headers && r.headers.get) ? (r.headers.get('content-type') || '') : '';
            if (!r.ok) {
                if (ct.indexOf('application/json') !== -1) {
                    return r.json().then(function (j) { throw new Error((j && j.message) ? j.message : ('Request failed (' + r.status + ')')); });
                }
                throw new Error('Request failed (' + r.status + ')');
            }
            if (ct.indexOf('application/json') === -1) {
                throw new Error('Unexpected response');
            }
            return r.json();
        })
        .then(function (json) {
            if (!json || json.success !== true) {
                throw new Error((json && json.message) ? json.message : 'Could not add to cart');
            }
            showCartToast(json.message || 'Added to cart', false);
            if (button) { button.innerHTML = origHtml; button.disabled = false; }
        })
        .catch(function (err) {
            if (button) { button.innerHTML = origHtml; button.disabled = false; }
            showCartToast((err && err.message) ? err.message : 'Could not add to cart', true);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {

        /* Slides carousel buttons */
        var slidesTrack = document.getElementById('gSlidesTrack');
        var slidesPrev = document.getElementById('gSlidesPrev');
        var slidesNext = document.getElementById('gSlidesNext');
        function scrollSlides(dir) {
            if (!slidesTrack) return;
            var firstCard = slidesTrack.querySelector('.g-slide-card');
            var cardW = firstCard ? firstCard.getBoundingClientRect().width : 260;
            var gap = 12;
            slidesTrack.scrollBy({ left: dir * (cardW + gap) * 2, behavior: 'smooth' });
        }
        if (slidesPrev) slidesPrev.addEventListener('click', function () { scrollSlides(-1); });
        if (slidesNext) slidesNext.addEventListener('click', function () { scrollSlides(1); });

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
