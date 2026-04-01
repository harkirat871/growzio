@foreach($categories as $cat)
    <li class="g-category-item" data-category-id="{{ $cat->id }}">
        <div class="g-category-row">
            <div style="display:flex;align-items:center;gap:0.5rem;flex:1;">
                @if($cat->relationLoaded('children') && $cat->children->isNotEmpty())
                    <span class="g-category-toggle" onclick="toggleUnityCategory({{ $cat->id }})" role="button" aria-expanded="false" aria-controls="unity-children-{{ $cat->id }}" tabindex="0">
                        <span id="unity-icon-{{ $cat->id }}" aria-hidden="true">▶</span>
                    </span>
                @else
                    <span style="width:1em;display:inline-block;">−</span>
                @endif
                <span class="g-category-name">{{ $cat->name }}</span>
            </div>
            <a href="{{ route('products.byCategory', $cat) }}" class="g-category-link">
                View
                @if(isset($cat->products_count))
                    <span>({{ $cat->products_count }})</span>
                @endif
            </a>
        </div>
        @if($cat->relationLoaded('children') && $cat->children->isNotEmpty())
            <ul class="g-category-children hidden" id="unity-children-{{ $cat->id }}" role="group" hidden>
                @include('products.categories._tree_unity', ['categories' => $cat->children])
            </ul>
        @endif
    </li>
@endforeach
