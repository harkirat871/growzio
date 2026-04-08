<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in - Growzio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        /* =============================================
           GROWZIO — DESIGN SYSTEM (same as index/register)
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
            --g-radius:     4px;
            --g-radius-lg:  10px;
            --font-head:    'Syne', sans-serif;
            --font-body:    'DM Sans', sans-serif;
            --font-mono:    'JetBrains Mono', monospace;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--g-bg);
            font-family: var(--font-body);
            font-size: 16px;
            line-height: 1.5;
            color: var(--g-text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        /* Login container */
        .g-login-container {
            max-width: 480px;
            width: 100%;
            background: var(--g-card-bg);
            border: 1px solid var(--g-border);
            border-radius: var(--g-radius-lg);
            padding: 2rem 1.5rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }

        @media (min-width: 640px) {
            .g-login-container {
                padding: 2.5rem;
            }
        }

        /* Headings */
        .g-login-title {
            font-family: var(--font-head);
            font-size: 1.75rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: var(--g-light);
            margin-bottom: 0.25rem;
        }

        .g-login-subtitle {
            font-size: 0.9375rem;
            color: var(--g-text-muted);
            margin-bottom: 1.75rem;
            border-left: 3px solid var(--g-accent);
            padding-left: 0.75rem;
        }

        /* Session status (success/error) */
        .g-session-status {
            background: rgba(255,211,105,0.1);
            border: 1px solid var(--g-border-hover);
            border-radius: var(--g-radius);
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            color: var(--g-accent);
            margin-bottom: 1.5rem;
        }

        /* Form elements */
        .g-form-group {
            margin-bottom: 1.25rem;
        }

        .g-label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 500;
            color: var(--g-text-muted);
            margin-bottom: 0.5rem;
            font-family: var(--font-mono);
            letter-spacing: 0.02em;
        }

        .g-input {
            width: 100%;
            background: var(--g-bg);
            border: 1px solid var(--g-border);
            border-radius: var(--g-radius);
            padding: 0.75rem 1rem;
            font-size: 0.9375rem;
            font-family: var(--font-body);
            color: var(--g-text);
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .g-input:focus {
            outline: none;
            border-color: var(--g-accent);
            box-shadow: 0 0 0 3px rgba(255,211,105,0.12);
        }

        .g-input::placeholder {
            color: rgba(238,238,238,0.3);
        }

        /* Password wrapper with toggle */
        .g-password-wrapper {
            position: relative;
        }

        .g-password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--g-text-muted);
            display: flex;
            align-items: center;
            padding: 0;
            transition: color 0.2s;
        }

        .g-password-toggle:hover {
            color: var(--g-accent);
        }

        /* Error message */
        .g-error {
            font-size: 0.75rem;
            color: #f87171;
            margin-top: 0.375rem;
            font-family: var(--font-mono);
        }

        /* Button & link row */
        .g-form-actions {
            margin-top: 1.75rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        @media (min-width: 480px) {
            .g-form-actions {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }
        }

        .g-link {
            font-size: 0.875rem;
            color: var(--g-text-muted);
            text-decoration: none;
            transition: color 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }

        .g-link:hover {
            color: var(--g-accent);
        }

        .g-btn {
            background: var(--g-accent);
            color: var(--g-bg);
            border: none;
            border-radius: var(--g-radius);
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            font-family: var(--font-body);
            cursor: pointer;
            transition: transform 0.2s, background 0.2s;
            width: 100%;
        }

        @media (min-width: 480px) {
            .g-btn {
                width: auto;
            }
        }

        .g-btn:hover {
            background: #e8bc52;
            transform: translateY(-1px);
        }

        .g-btn:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <div class="g-login-container">
        <h1 class="g-login-title">Welcome back</h1>
        <div class="g-login-subtitle">Log in to your account</div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="g-session-status">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="g-form-group">
                <label for="email" class="g-label">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    placeholder="you@example.com"
                    class="g-input">
                @error('email')<p class="g-error">{{ $message }}</p>@enderror
            </div>

            <!-- Password -->
            <div class="g-form-group">
                <label for="password" class="g-label">Password</label>
                <div class="g-password-wrapper">
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        placeholder="••••••••"
                        class="g-input" style="padding-right: 2.5rem;">
                    <button type="button" class="g-password-toggle" onclick="togglePassword()" aria-label="Toggle password visibility">
                        <svg id="eye-icon" class="h-5 w-5" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                @error('password')<p class="g-error">{{ $message }}</p>@enderror
            </div>

            <div class="g-form-actions">
                <a href="{{ route('register') }}" class="g-link">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                    Create an account
                </a>
                <button type="submit" class="g-btn">Log in</button>
            </div>
        </form>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const eye = document.getElementById('eye-icon');
            
            if (input.type === 'password') {
                input.type = 'text';
                eye.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';
            } else {
                input.type = 'password';
                eye.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
            }
        }
    </script>
</body>
</html>