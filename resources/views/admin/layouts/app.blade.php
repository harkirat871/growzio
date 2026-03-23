<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-timezone" content="{{ config('app.timezone') }}">
    <title>{{ config('app.name', 'Laravel') }} - Admin</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <style>
        :root { --admin-primary: #0A0A0A; --admin-secondary: #1A1A1A; --admin-accent: #2563EB; --admin-text: #F4F4F5; --admin-text-muted: #71717A; --admin-border: rgba(255,255,255,0.08); }
        .admin-sidebar { background: var(--admin-primary); border-right: 1px solid var(--admin-border); }
        .admin-sidebar-link { color: var(--admin-text-muted); display: flex; align-items: center; gap: 0.75rem; padding: 0.5rem 0.75rem; border-radius: 6px; text-decoration: none; }
        .admin-sidebar-link:hover { background: rgba(255,255,255,0.04); color: var(--admin-text-muted); }
        .admin-sidebar-link.active { background: rgba(37,99,235,0.15); color: var(--admin-accent); border-left: 3px solid var(--admin-accent); margin-left: -3px; padding-left: calc(0.75rem + 3px); }
        .admin-main { background: var(--admin-secondary); min-height: 100vh; }
        .admin-main .bg-white { background: rgba(255,255,255,0.04) !important; border: 1px solid var(--admin-border); }
        .admin-main .text-gray-900, .admin-main .text-gray-800 { color: var(--admin-text) !important; }
        .admin-main .text-gray-500, .admin-main .text-gray-600, .admin-main .text-gray-700 { color: var(--admin-text-muted) !important; }
        .admin-main .border-gray-200, .admin-main .border-gray-300 { border-color: var(--admin-border) !important; }
        .admin-main .divide-gray-200 > * { border-color: var(--admin-border) !important; }
        .admin-main a:not(.no-admin-style) { color: #60a5fa; }
        .admin-main a:not(.no-admin-style):hover { color: #60a5fa; opacity: 0.9; }
        .admin-main input, .admin-main select, .admin-main textarea { background: #f3f4f6 !important; border: 1px solid #d1d5db !important; color: #1f2937 !important; }
        .admin-main input::placeholder, .admin-main textarea::placeholder { color: #6b7280; }
        .admin-main select option { background: #fff; color: #1f2937; }
        .admin-main .bg-indigo-600 { background: var(--admin-accent) !important; }
        .admin-main .bg-indigo-600:hover, .admin-main .hover\:bg-indigo-700:hover { background: #1d4ed8 !important; }
        .admin-main .bg-gray-100 { background: rgba(255,255,255,0.06) !important; }
        .admin-main .bg-blue-100 { background: rgba(37,99,235,0.15) !important; }
        .admin-main .text-blue-800 { color: #60a5fa !important; }
        .admin-main .bg-gray-600 { background: #374151 !important; }
        .admin-main .bg-red-600 { background: #dc2626 !important; color: #fff !important; }
        .admin-main .bg-red-600:hover, .admin-main .hover\:bg-red-700:hover { background: #b91c1c !important; color: #fff !important; }
        .admin-main button.text-red-600, .admin-main a.text-red-600, .admin-main button.text-red-700, .admin-main a.text-red-700 { color: #fff !important; }
        .admin-main .hover\:bg-gray-50:hover, .admin-main .hover\:bg-gray-100:hover, .admin-main .hover\:bg-gray-200:hover, .admin-main .hover\:bg-red-50:hover { background: rgba(255,255,255,0.06) !important; }
        .admin-row-hover:hover { background: rgba(255,255,255,0.06); }
        .admin-edit-btn { background: rgba(37,99,235,0.15); border-color: var(--admin-accent); color: #60a5fa; }
        .admin-edit-btn:hover { background: rgba(37,99,235,0.2); }
        .admin-delete-btn { background: #dc2626; border-color: #dc2626; color: #fff; }
        .admin-delete-btn:hover { background: #b91c1c; border-color: #b91c1c; }
        .admin-mobile-overlay { background: rgba(0,0,0,0.5); }
        .admin-mobile-sidebar { transform: translateX(-100%); }
        .admin-mobile-sidebar.open { transform: translateX(0); }
        @media (min-width: 1024px) { .admin-mobile-header { display: none; } }
        @media (max-width: 1023px) { .admin-desktop-sidebar { display: none; } }
    </style>
</head>
<body class="font-sans antialiased" style="background: var(--admin-primary); color: var(--admin-text);">
<div x-data="{ mobileOpen: false }" class="min-h-screen">
    {{-- Fixed sidebar (desktop) --}}
    <aside class="admin-desktop-sidebar fixed left-0 top-0 bottom-0 w-64 flex flex-col z-20" style="background: var(--admin-primary); border-right: 1px solid var(--admin-border);">
        <div class="p-4 border-b flex-shrink-0" style="border-color: var(--admin-border);">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 font-semibold text-lg" style="color: var(--admin-text); text-decoration: none;">
                <span style="color: var(--admin-accent);">●</span> {{ config('app.name') }} Admin
            </a>
        </div>
        <nav class="flex-1 p-3 space-y-0.5 overflow-y-auto" style="max-height: calc(100vh - 220px);">
            <a href="{{ route('admin.dashboard') }}" class="admin-sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Home
            </a>
            <a href="{{ route('admin.products.index') }}" class="admin-sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                Products
            </a>
            <a href="{{ route('admin.orders.index') }}" class="admin-sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                Orders
            </a>
            <a href="{{ route('admin.customers.index') }}" class="admin-sidebar-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Customers
            </a>
            <a href="{{ route('admin.categories.index') }}" class="admin-sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                Catalog
            </a>
            <a href="{{ route('home') }}" class="admin-sidebar-link mt-2" style="color: var(--admin-accent);">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to store
            </a>
        </nav>
        <div class="p-3 border-t flex-shrink-0" style="border-color: var(--admin-border);">
            <div class="text-xs" style="color: var(--admin-text-muted);">{{ Auth::user()->name }}</div>
            <form method="POST" action="{{ route('logout') }}" class="mt-1">
                @csrf
                <button type="submit" class="text-sm px-1 -ml-1 rounded hover:opacity-80" style="color: var(--admin-text-muted);">Log out</button>
            </form>
        </div>
    </aside>

    {{-- Top header: Back to store (always visible) --}}
    <header class="fixed top-0 right-0 left-0 lg:left-64 z-30 flex items-center justify-between px-4 py-3 h-14" style="background: var(--admin-primary); border-bottom: 1px solid var(--admin-border);">
        <button @click="mobileOpen = !mobileOpen" type="button" class="lg:hidden p-2 -ml-2 rounded" style="color: var(--admin-text-muted);">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        <span class="lg:hidden font-medium" style="color: var(--admin-text);">{{ config('app.name') }} Admin</span>
        <a href="{{ route('home') }}" class="flex items-center gap-2 px-3 py-2 rounded text-sm font-medium" style="background: rgba(37,99,235,0.2); color: #60a5fa; text-decoration: none;">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to store
        </a>
    </header>

    {{-- Mobile sidebar overlay --}}
    <div @click="mobileOpen = false" x-show="mobileOpen" x-cloak class="admin-mobile-overlay fixed inset-0 z-40 lg:hidden" style="display: none;"></div>

    {{-- Mobile sidebar (slide-in) --}}
    <aside :class="mobileOpen ? 'open' : ''" class="admin-mobile-sidebar fixed left-0 top-0 bottom-0 w-64 z-50 lg:hidden flex flex-col" style="background: var(--admin-primary); border-right: 1px solid var(--admin-border); transition: transform 0.2s ease;">
        <div class="p-4 pt-16 border-b flex-shrink-0 space-y-1" style="border-color: var(--admin-border);">
            <a href="{{ route('admin.dashboard') }}" @click="mobileOpen = false" class="admin-sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Home</a>
            <a href="{{ route('admin.products.index') }}" @click="mobileOpen = false" class="admin-sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">Products</a>
            <a href="{{ route('admin.orders.index') }}" @click="mobileOpen = false" class="admin-sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">Orders</a>
            <a href="{{ route('admin.customers.index') }}" @click="mobileOpen = false" class="admin-sidebar-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">Customers</a>
            <a href="{{ route('admin.categories.index') }}" @click="mobileOpen = false" class="admin-sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">Catalog</a>
            <a href="{{ route('home') }}" class="admin-sidebar-link mt-2">Back to store →</a>
        </div>
    </aside>

    {{-- Main content --}}
    <main class="admin-main pt-14 lg:pl-64" style="min-height: 100vh;">
        <div class="p-4 sm:p-6 lg:p-8">
            @if (session('success'))
                <div class="mb-6 rounded-lg px-4 py-3 text-sm" style="background: rgba(34,197,94,0.15); border: 1px solid rgba(34,197,94,0.3); color: #4ade80;">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-6 rounded-lg px-4 py-3 text-sm" style="background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3); color: #f87171;">{{ session('error') }}</div>
            @endif
            @if ($errors->any())
                <div class="mb-6 rounded-lg px-4 py-3 text-sm" style="background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3); color: #f87171;">
                    <ul class="list-disc list-inside">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif
            @yield('content')
        </div>
    </main>
</div>
<style>[x-cloak]{display:none!important}</style>
@stack('scripts')
</body>
</html>
