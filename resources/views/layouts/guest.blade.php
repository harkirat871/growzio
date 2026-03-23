<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-timezone" content="{{ config('app.timezone') }}">
    <title>@yield('title', 'Create account') — {{ config('app.name', 'Store') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'DM Sans', system-ui, sans-serif; }
        .guest-wrap { min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; background: linear-gradient(160deg, #f8fafc 0%, #f1f5f9 50%, #e2e8f0 100%); padding: 2rem 1rem; }
        .guest-card { width: 100%; max-width: 420px; background: #fff; border-radius: 20px; box-shadow: 0 4px 24px rgba(15, 23, 42, 0.08), 0 1px 3px rgba(15, 23, 42, 0.06); padding: 2.5rem; }
        .guest-logo { display: block; text-align: center; margin-bottom: 1.5rem; font-size: 1.5rem; font-weight: 700; color: #0f172a; text-decoration: none; letter-spacing: -0.02em; }
        .guest-logo:hover { color: #334155; }
    </style>
</head>
<body class="antialiased text-gray-900">
    <div class="guest-wrap">
        <a href="{{ url('/') }}" class="guest-logo">{{ config('app.name', 'Store') }}</a>
        <div class="guest-card">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
