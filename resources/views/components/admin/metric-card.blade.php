@props([
    'title',
    'value',
    'subtitle' => null,
    'tooltip' => null,
    'compact' => false,
    'truncate' => false,
])

<div {{ $attributes->merge(['class' => 'rounded-xl p-5 transition hover:shadow-lg']) }} style="background: rgba(255,255,255,0.04); border: 1px solid var(--admin-border);">
    <div class="flex items-start justify-between gap-2">
        <div class="min-w-0 flex-1">
            <div class="flex items-center gap-1.5 mb-0.5">
                <span class="text-xs font-medium uppercase" style="color: var(--admin-text-muted);">{{ $title }}</span>
                @if ($tooltip)
                    <span class="group/tip relative inline-flex shrink-0" title="{{ $tooltip }}">
                        <svg class="w-3.5 h-3.5 cursor-help opacity-60 hover:opacity-100 transition-opacity" style="color: var(--admin-text-muted);" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                        <span class="pointer-events-none absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2.5 py-1.5 text-xs rounded-lg opacity-0 invisible group-hover/tip:opacity-100 group-hover/tip:visible transition-all duration-150 z-50 max-w-[240px] text-left" style="background: var(--admin-primary); border: 1px solid var(--admin-border); color: var(--admin-text); box-shadow: 0 4px 12px rgba(0,0,0,0.3);">
                            {{ $tooltip }}
                        </span>
                    </span>
                @endif
            </div>
            @if ($subtitle)
                <p class="text-[11px] leading-tight mb-1.5" style="color: var(--admin-text-muted); opacity: 0.85;">{{ $subtitle }}</p>
            @endif
        </div>
    </div>
    <div class="{{ $compact ? 'font-semibold text-base' : 'text-xl font-bold' }} {{ $truncate ? 'truncate' : '' }}" style="color: var(--admin-text);" @if($truncate) title="{{ $value }}" @endif>{{ $value }}</div>
</div>
