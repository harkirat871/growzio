@extends('admin.layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 space-y-4">
                    @if ($product->image_path)
                        <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" class="w-64 h-64 object-cover rounded">
                    @endif
                    <div><span class="font-semibold">Name:</span> {{ $product->name }}</div>
                    <div><span class="font-semibold">Price:</span> ₹{{ number_format($product->price, 2) }}</div>
                    <div><span class="font-semibold">Stock:</span> {{ $product->stock }}</div>
                    <div><span class="font-semibold">Description:</span> {{ $product->description }}</div>
        </div>
    </div>
</div>
@endsection


