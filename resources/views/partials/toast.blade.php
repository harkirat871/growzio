@php
    /** @var array{type?:string,message?:string}|null $toast */
    $toast = session('toast');
    $toastType = is_array($toast) ? ($toast['type'] ?? 'success') : null;
    $toastMessage = is_array($toast) ? ($toast['message'] ?? '') : '';

    // Fallback: many pages still set session('status')
    if ((!$toastMessage || !$toastType) && session()->has('status')) {
        $toastType = 'success';
        $toastMessage = (string) session('status');
    }

    $toastType = in_array($toastType, ['success', 'error', 'info'], true) ? $toastType : 'info';
    $toastMessage = trim((string) $toastMessage);
@endphp

@if($toastMessage !== '')
    <div id="g-toast-host" style="position: fixed; inset: auto 0 0 0; z-index: 9999; pointer-events: none;">
        <div
            id="g-toast"
            role="status"
            aria-live="polite"
            data-type="{{ $toastType }}"
            style="
                pointer-events: none;
                position: fixed;
                left: 12px;
                right: 12px;
                bottom: 14px;
                max-width: 520px;
                margin: 0 auto;
                padding: 10px 12px;
                border-radius: 10px;
                border: 1px solid rgba(255,255,255,0.12);
                background: rgba(17,24,39,0.92);
                color: rgba(255,255,255,0.92);
                box-shadow: 0 10px 30px rgba(0,0,0,0.35);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                font-size: 13px;
                line-height: 1.35;
                display: flex;
                align-items: center;
                gap: 10px;
                transform: translateY(10px);
                opacity: 0;
                transition: transform 160ms ease, opacity 160ms ease;
            "
        >
            <span
                aria-hidden="true"
                style="
                    width: 8px;
                    height: 8px;
                    border-radius: 999px;
                    flex: 0 0 auto;
                    background: {{ $toastType === 'success' ? '#34d399' : ($toastType === 'error' ? '#f87171' : '#60a5fa') }};
                "
            ></span>
            <span style="flex: 1 1 auto; min-width: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                {{ $toastMessage }}
            </span>
        </div>
    </div>

    <script>
        (function () {
            var el = document.getElementById('g-toast');
            if (!el) return;

            // Ensure single toast (remove any previous)
            document.querySelectorAll('#g-toast').forEach(function (n) {
                if (n !== el && n && n.parentNode) n.parentNode.removeChild(n);
            });

            requestAnimationFrame(function () {
                el.style.opacity = '1';
                el.style.transform = 'translateY(0)';
            });

            var timeoutMs = 2500;
            setTimeout(function () {
                el.style.opacity = '0';
                el.style.transform = 'translateY(10px)';
                setTimeout(function () {
                    if (el && el.parentNode) el.parentNode.removeChild(el);
                }, 180);
            }, timeoutMs);
        })();
    </script>
@endif

