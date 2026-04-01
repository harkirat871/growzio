<div class="col-6 col-md-4 col-lg-3 g-product-col">
    <div class="g-product-card">
        <a href="{{ route('products.show', $product) }}" class="g-product-link">
            <div class="g-product-image">
                @if ($product->image_path)
                    <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}">
                @else
                    <div class="g-product-image-placeholder">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <path d="M21 15l-5-5L5 21"/>
                        </svg>
                    </div>
                @endif
            </div>
            <div class="g-product-details">
                <span class="g-product-name">{{ $product->name }}</span>
                <span class="g-product-price">₹{{ number_format((float) $product->price, 2) }}</span>
                @php
                    $categoryName = $product->category?->name ?? '';
                    $partNo = $product->company_part_number ?? '';
                @endphp
                @if($categoryName || $partNo)
                    <div class="g-product-meta">
                        @if($categoryName)
                            <span class="g-product-category">{{ $categoryName }}</span>
                        @endif
                        @if($partNo)
                            <span class="g-product-partno">{{ $partNo }}</span>
                        @endif
                    </div>
                @endif
            </div>
        </a>
        <div class="g-product-actions">
            <form method="POST" action="{{ route('cart.add', $product) }}" class="g-add-form" onclick="event.stopPropagation()">
                @csrf
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="g-btn-add">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                        <path d="M3 6h18"/>
                        <path d="M16 10a4 4 0 0 1-8 0"/>
                    </svg>
                    Add to Cart
                </button>
            </form>
        </div>
    </div>
</div>
