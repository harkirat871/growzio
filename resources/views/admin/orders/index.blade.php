<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin: Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full text-left">
                        <thead>
                            <tr class="border-b">
                                <th class="p-2">ID</th>
                                <th class="p-2">Customer</th>
                                <th class="p-2">Items</th>
                                <th class="p-2">Total</th>
                                <th class="p-2">Status</th>
                                <th class="p-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr class="border-b">
                                    <td class="p-2">#{{ $order->id }}</td>
                                    <td class="p-2">{{ $order->guest_name ?? optional($order->user)->name }}</td>
                                    <td class="p-2">{{ $order->items_count }}</td>
                                    <td class="p-2">$ {{ number_format($order->total, 2) }}</td>
                                    <td class="p-2">{{ ucfirst($order->status) }}</td>
                                    <td class="p-2">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="text-indigo-600 hover:underline">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $orders->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


