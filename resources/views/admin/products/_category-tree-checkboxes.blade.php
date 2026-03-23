@foreach($categories as $category)
    <li class="category-item" data-category-id="{{ $category->id }}">
        <div class="px-2 py-1.5 flex items-center gap-2">
            @if($category->children->isNotEmpty())
                <span
                    class="category-toggle mr-1 cursor-pointer select-none"
                    style="color: var(--admin-text-muted, #71717a);"
                    onclick="toggleCategory({{ $category->id }})"
                >
                    <span class="expand-icon" id="icon-{{ $category->id }}">▼</span>
                </span>
            @else
                <span class="category-toggle mr-1 text-gray-400 select-none">-</span>
            @endif

            <input
                type="checkbox"
                id="category-checkbox-{{ $category->id }}"
                name="category_ids[]"
                value="{{ $category->id }}"
                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
            >
            <label
                for="category-checkbox-{{ $category->id }}"
                class="text-sm font-medium text-gray-900 cursor-pointer"
            >
                {{ $category->name }}
            </label>
        </div>

        @if($category->children->isNotEmpty())
            <ul class="ml-6 mt-1" id="children-{{ $category->id }}">
                @include('admin.products._category-tree-checkboxes', ['categories' => $category->children])
            </ul>
        @endif
    </li>
@endforeach

