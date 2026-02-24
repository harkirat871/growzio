@foreach($categories as $cat)
    <li class="unity-category-item" data-category-id="{{ $cat->id }}">
        <div class="unity-category-row">
            <div style="display:flex;align-items:center;gap:0.5rem;flex:1;">
                @if($cat->relationLoaded('children') && $cat->children->isNotEmpty())
                    <span class="unity-category-toggle" onclick="toggleUnityCategory({{ $cat->id }})" role="button" aria-expanded="false" aria-controls="unity-children-{{ $cat->id }}" tabindex="0">
                        <span id="unity-icon-{{ $cat->id }}" aria-hidden="true">▶</span>
                    </span>
                @else
                    <span style="width:1em;display:inline-block;">−</span>
                @endif
                <span class="unity-category-name">{{ $cat->name }}</span>
            </div>
            <a href="{{ route('products.byCategory', $cat) }}" class="unity-category-link">
                View
                @if(isset($cat->products_count))
                    <span>({{ $cat->products_count }})</span>
                @endif
            </a>
        </div>
        @if($cat->relationLoaded('children') && $cat->children->isNotEmpty())
            <ul class="unity-category-children hidden" id="unity-children-{{ $cat->id }}" role="group" style="list-style:none;margin:0;padding-left:1rem;">
                @include('products.categories._tree_unity', ['categories' => $cat->children])
            </ul>
        @endif
    </li>
@endforeach
