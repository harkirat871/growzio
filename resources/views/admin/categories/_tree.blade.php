@foreach($categories as $category)
    <li class="category-item" data-category-id="{{ $category->id }}">
        <div class="px-4 py-3 flex items-center justify-between admin-row-hover">
            <div class="flex items-center flex-1">
                <span class="category-toggle mr-2 cursor-pointer" style="color: var(--admin-text-muted, #71717a);" onclick="toggleCategory({{ $category->id }})">
                    @if($category->children->isNotEmpty())
                        <span class="expand-icon" id="icon-{{ $category->id }}">▼</span>
                    @else
                        <span class="text-gray-400">-</span>
                    @endif
                </span>
                <div class="flex-1">
                    <span class="text-sm font-medium text-gray-900">{{ $category->name }}</span>
                    <button type="button"
                            class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 hover:bg-blue-200 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-300"
                            onclick="if(confirm({{ json_encode('Would you like to see what products are there in ' . $category->name . '?') }})) { window.location.href='{{ route('products.byCategory', $category) }}'; }">
                        {{ $category->products_count ?? 0 }} products
                    </button>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.categories.edit', $category) }}" 
                   class="inline-flex items-center px-3 py-1.5 border text-sm font-medium rounded-md admin-edit-btn focus:outline-none">
                    Edit
                </a>
                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="inline-flex items-center px-3 py-1.5 border text-sm font-medium rounded-md admin-delete-btn focus:outline-none" 
                            onclick="return confirm('Are you sure you want to delete this category?')">
                        Delete
                    </button>
                </form>
            </div>
        </div>
        @if($category->children->isNotEmpty())
            <ul class="children-list ml-6" id="children-{{ $category->id }}">
                @include('admin.categories._tree', ['categories' => $category->children])
            </ul>
        @endif
    </li>
@endforeach
