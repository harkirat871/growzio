@foreach($categories as $cat)
    <li class="category-tree-item" data-category-id="{{ $cat->id }}">
        <div class="category-list-row">
            <div class="category-list-row-inner">
                @if($cat->relationLoaded('children') && $cat->children->isNotEmpty())
                    <span class="category-toggle" onclick="toggleCategory({{ $cat->id }})" role="button" aria-expanded="false" aria-controls="children-{{ $cat->id }}" aria-label="Expand subcategories" tabindex="0">
                        <span class="category-expand-icon" id="icon-{{ $cat->id }}" aria-hidden="true">▶</span>
                    </span>
                @else
                    <span class="category-toggle category-toggle-disabled" aria-hidden="true">
                        <span class="category-expand-placeholder">−</span>
                    </span>
                @endif
                <span class="category-list-name">{{ $cat->name }}</span>
            </div>
            <a href="{{ route('products.byCategory', $cat) }}" class="category-view-products" aria-label="View products in {{ $cat->name }}">
                View products
                @if(isset($cat->products_count))
                    <span class="category-view-count">({{ $cat->products_count }})</span>
                @endif
            </a>
        </div>
        @if($cat->relationLoaded('children') && $cat->children->isNotEmpty())
            <ul class="category-children hidden" id="children-{{ $cat->id }}" role="group">
                @include('products.categories._tree', ['categories' => $cat->children])
            </ul>
        @endif
    </li>
@endforeach
