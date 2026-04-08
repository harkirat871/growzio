<div
  class="export-wrapper"
  style="
    width: 1440px;
    min-height: 812px;
    position: relative;
    font-family: var(--font-family-body);
    background-color: var(--background);
  "
>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@100;200;300;400;500;600;700;800;900&family=Geist:wght@100;200;300;400;500;600;700;800;900&family=IBM+Plex+Mono:wght@100;200;300;400;500;600;700&family=IBM+Plex+Sans:wght@100;200;300;400;500;600;700&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:wght@200;300;400;500;600;700;800;900&family=PT+Serif:wght@400;700&family=Roboto+Slab:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@100;300;400;500;700;900&family=Shantell+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@300;400;500;600;700&display=swap"
    rel="stylesheet"
  />
  <html>
    <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>Login Required - Growzio</title>
      <link rel="preconnect" href="https://fonts.googleapis.com" />
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="" />
      <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&amp;family=DM+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&amp;family=JetBrains+Mono:wght@400;500&amp;display=swap"
        rel="stylesheet"
      />
      <style id="growzio-theme">
        /* =============================================
           GROWZIO — DESIGN SYSTEM
           ============================================= */
        :root {
          --g-bg: #222831;
          --g-bg2: #393e46;
          --g-accent: #ffd369;
          --g-light: #eeeeee;
          --g-text: #eeeeee;
          --g-text-muted: rgba(238, 238, 238, 0.55);
          --g-border: rgba(238, 238, 238, 0.1);
          --g-border-hover: rgba(255, 211, 105, 0.35);
          --g-card-bg: #2d3340;
          --g-radius: 4px;
          --g-radius-lg: 10px;
          --font-head: "Syne", sans-serif;
          --font-body: "DM Sans", sans-serif;
          --font-mono: "JetBrains Mono", monospace;
        }

        * {
          margin: 0;
          padding: 0;
          box-sizing: border-box;
        }

        .export-wrapper {
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
      </style>

      <style id="login-required-styles">
        /* Login container */
        .g-login-container {
          max-width: 480px;
          width: 100%;
          background: var(--g-card-bg);
          border: 1px solid var(--g-border);
          border-radius: var(--g-radius-lg);
          padding: 2rem 1.5rem;
          box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
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

        /* Benefits Box */
        .g-benefits {
          background: rgba(255, 211, 105, 0.05);
          border: 1px solid var(--g-border);
          border-radius: var(--g-radius);
          padding: 1.25rem;
          margin-bottom: 1.75rem;
        }

        .g-benefit-item {
          display: flex;
          align-items: flex-start;
          gap: 0.75rem;
          font-size: 0.875rem;
          color: var(--g-text-muted);
          margin-bottom: 0.75rem;
        }

        .g-benefit-item:last-child {
          margin-bottom: 0;
        }

        .g-benefit-icon {
          color: var(--g-accent);
          flex-shrink: 0;
          margin-top: 0.125rem;
        }

        /* Actions */
        .g-btn-block {
          background: var(--g-accent);
          color: var(--g-bg);
          border: none;
          border-radius: var(--g-radius);
          padding: 0.875rem 1.5rem;
          font-weight: 600;
          font-size: 0.9375rem;
          font-family: var(--font-body);
          cursor: pointer;
          transition:
            transform 0.2s,
            background 0.2s;
          width: 100%;
          display: flex;
          align-items: center;
          justify-content: center;
          text-decoration: none;
          margin-bottom: 1.25rem;
        }

        .g-btn-block:hover {
          background: #e8bc52;
          transform: translateY(-1px);
        }

        .g-signup-text {
          text-align: center;
          font-size: 0.875rem;
          color: var(--g-text-muted);
          margin-bottom: 1.5rem;
        }

        .g-signup-text a {
          color: var(--g-accent);
          text-decoration: none;
          font-weight: 600;
          margin-left: 0.25rem;
          transition: color 0.2s;
        }

        .g-signup-text a:hover {
          color: #e8bc52;
        }

        .g-divider {
          height: 1px;
          background: var(--g-border);
          margin: 1.5rem 0;
        }

        .g-link {
          font-size: 0.875rem;
          color: var(--g-text-muted);
          text-decoration: none;
          transition: color 0.2s;
          display: flex;
          align-items: center;
          justify-content: center;
          gap: 0.4rem;
        }

        .g-link:hover {
          color: var(--g-accent);
        }
      </style>
    </head>
    <body>
      <div class="g-login-container">
        <h1 class="g-login-title">Login Required</h1>
        <div class="g-login-subtitle">
          To complete your purchase and access exclusive features, please log
          in.
        </div>

        <!-- Concise Benefits Box -->
        <div class="g-benefits">
          <div class="g-benefit-item">
            <div class="g-benefit-icon">
              <svg
                width="16"
                height="16"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              >
                <path d="M20 6L9 17l-5-5"></path>
              </svg>
            </div>
            <span>Save cart and track order history</span>
          </div>
          <div class="g-benefit-item">
            <div class="g-benefit-icon">
              <svg
                width="16"
                height="16"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              >
                <path d="M20 6L9 17l-5-5"></path>
              </svg>
            </div>
            <span>Faster checkout process</span>
          </div>
          <div class="g-benefit-item">
            <div class="g-benefit-icon">
              <svg
                width="16"
                height="16"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              >
                <path d="M20 6L9 17l-5-5"></path>
              </svg>
            </div>
            <span>Exclusive member discounts &amp; perks</span>
          </div>
        </div>

        <!-- Actions -->
        <a
          href="{{ route('login') }}"
          class="g-btn-block"
          data-media-type="banani-button"
        >
          Log in to continue
        </a>

        <div class="g-signup-text">
          Don't have an account?
          <a href="{{ route('register') }}" data-media-type="banani-button"
            >Create new</a
          >
        </div>

        <div class="g-divider"></div>

        <a
          href="{{ route('cart.view') }}"
          class="g-link"
          data-media-type="banani-button"
        >
          <svg
            width="16"
            height="16"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
          >
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
          </svg>
          Back to Cart
        </a>
      </div>
    </body>
  </html>
  <script src="https://code.iconify.design/iconify-icon/3.0.0/iconify-icon.min.js"></script>
  <style>
    :root {
      --background: #222831;
      --foreground: #eeeeee;
      --border: #1f2933;
      --input: #222831;
      --primary: #ffd369;
      --primary-foreground: #222831;
      --secondary: #2d3340;
      --secondary-foreground: #eeeeee;
      --muted: #393e46;
      --muted-foreground: rgba(238, 238, 238, 0.55);
      --success: #4ade80;
      --success-foreground: #022c22;
      --accent: #ffd369;
      --accent-foreground: #222831;
      --destructive: #ff6b6b;
      --destructive-foreground: #2b0b0b;
      --warning: #ffb86b;
      --warning-foreground: #2b1700;
      --card: #2d3340;
      --card-foreground: #eeeeee;
      --sidebar: #1f2430;
      --sidebar-foreground: #cfd8dc;
      --sidebar-primary: #ffd369;
      --sidebar-primary-foreground: #222831;
      --radius-sm: 4px;
      --radius-md: 6px;
      --radius-lg: 10px;
      --radius-xl: 12px;
      --font-family-body: DM Sans;
    }
  </style>
</div>
