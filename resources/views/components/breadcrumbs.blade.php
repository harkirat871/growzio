@props(['items' => []])

<nav aria-label="Breadcrumb" class="mb-4">
    <ol class="flex flex-wrap items-center gap-1 text-sm text-gray-500">
        <li><a href="{{ route('admin.dashboard') }}" class="hover:text-gray-700">Home</a></li>
        @foreach ($items as $label => $url)
            <li class="flex items-center gap-1">
                <span aria-hidden="true">/</span>
                @if ($url)
                    <a href="{{ $url }}" class="hover:text-gray-700">{{ $label }}</a>
                @else
                    <span class="text-gray-900 font-medium">{{ $label }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
