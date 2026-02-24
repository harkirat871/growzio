{{-- Unity-style product card. On phone: one per row, square image left, details right, big Add to Cart. --}}
<div class="col-6 col-md-4 col-lg-3 unity-product-col">
    <div class="unity-product-card">
        <a href="{{ route('products.show', $product) }}" class="unity-product-link">
            <div class="unity-product-image">
                @if ($product->image_path)
                    <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}">
                @else
                    <div class="unity-product-image-placeholder">
                        <svg class="unity-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                    </div>
                @endif
            </div>
            <div class="unity-product-details">
                <span class="unity-product-name">{{ $product->name }}</span>
                <span class="unity-product-price">₹{{ number_format((float) $product->price, 2) }}</span>
                <div class="unity-product-meta">
                    @if($product->relationLoaded('category') && $product->category)
                        <span class="unity-product-category">{{ $product->category->name }}</span>
                    @endif
                    @if($product->company_part_number)
                        <span class="unity-product-partno">{{ $product->company_part_number }}</span>
                    @endif
                </div>
            </div>
        </a>
        <div class="unity-product-actions">
            <form method="POST" action="{{ route('cart.add', $product) }}" class="unity-add-form" onclick="event.stopPropagation()">
                @csrf
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="unity-btn unity-btn-add">
                    Add to Cart
                </button>
            </form>
        </div>
    </div>
</div>
