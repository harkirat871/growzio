@extends('admin.layouts.app')

@section('content')
<div class="max-w-[1600px] mx-auto">
    <x-breadcrumbs :items="['Customers' => null]" />
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <h1 class="text-2xl font-semibold" style="color: var(--admin-text);">Customer Analytics</h1>
        <div class="flex flex-wrap items-center gap-3">
            <form method="GET" action="{{ route('admin.customers.index') }}" class="flex gap-2 items-center">
                <input type="hidden" name="filter" value="{{ $filter }}">
                <input type="hidden" name="sort" value="{{ $sortBy }}">
                <input type="hidden" name="dir" value="{{ $sortDir }}">
                <input type="search" name="search" value="{{ $search }}"
                    placeholder="Search name or email..."
                    class="rounded-lg border px-3 py-2 text-sm w-48 sm:w-56 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <button type="submit" class="px-4 py-2 rounded-lg text-sm font-medium bg-indigo-600 text-white hover:bg-indigo-700 transition">Search</button>
            </form>
            <a href="{{ route('admin.customers.export', ['filter' => $filter]) }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition"
                style="background: rgba(37,99,235,0.2); color: #60a5fa; border: 1px solid rgba(37,99,235,0.4);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Export CSV
            </a>
        </div>
    </div>

    {{-- Filters --}}
    <div class="flex flex-wrap gap-2 mb-6">
        @php
            $filters = [
                null => 'All',
                'active_30' => 'Active (30 days)',
                'no_orders_60' => 'No orders 60+ days',
                'top_10' => 'Top 10',
                'high_loyalty' => 'High loyalty',
            ];
        @endphp
        @foreach ($filters as $f => $label)
            <a href="{{ route('admin.customers.index', array_merge(request()->except('filter'), ['filter' => $f])) }}"
                class="inline-flex px-3 py-1.5 text-sm rounded-full transition {{ $filter === $f ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
                style="{{ $filter === $f ? 'background: var(--admin-accent) !important; color: white !important;' : '' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- Table --}}
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-4 sm:p-6">
            {{-- Desktop table --}}
            <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full text-left">
                <thead>
                    <tr class="border-b" style="border-color: var(--admin-border);">
                        <th class="p-3 text-xs font-medium uppercase" style="color: var(--admin-text-muted);">Name</th>
                        <th class="p-3 text-xs font-medium uppercase" style="color: var(--admin-text-muted);">Email</th>
                        <th class="p-3 text-xs font-medium uppercase" style="color: var(--admin-text-muted);">
                            <a href="{{ route('admin.customers.index', array_merge(request()->except(['sort','dir']), ['sort'=>'total_spend','dir'=>$sortBy==='total_spend'&&$sortDir==='desc'?'asc':'desc'])) }}" class="hover:underline">Total Spend</a>
                        </th>
                        <th class="p-3 text-xs font-medium uppercase" style="color: var(--admin-text-muted);">
                            <a href="{{ route('admin.customers.index', array_merge(request()->except(['sort','dir']), ['sort'=>'total_orders','dir'=>$sortBy==='total_orders'&&$sortDir==='desc'?'asc':'desc'])) }}" class="hover:underline">Orders</a>
                        </th>
                        <th class="p-3 text-xs font-medium uppercase" style="color: var(--admin-text-muted);">Avg Order</th>
                        <th class="p-3 text-xs font-medium uppercase" style="color: var(--admin-text-muted);">Last Order</th>
                        <th class="p-3 text-xs font-medium uppercase" style="color: var(--admin-text-muted);">
                            <a href="{{ route('admin.customers.index', array_merge(request()->except(['sort','dir']), ['sort'=>'last_login','dir'=>$sortBy==='last_login'&&$sortDir==='desc'?'asc':'desc'])) }}" class="hover:underline">Last Login</a>
                        </th>
                        <th class="p-3 text-xs font-medium uppercase" style="color: var(--admin-text-muted);">
                            <a href="{{ route('admin.customers.index', array_merge(request()->except(['sort','dir']), ['sort'=>'loyalty_points','dir'=>$sortBy==='loyalty_points'&&$sortDir==='desc'?'asc':'desc'])) }}" class="hover:underline">Loyalty</a>
                        </th>
                        <th class="p-3 text-xs font-medium uppercase" style="color: var(--admin-text-muted);">Status</th>
                        <th class="p-3 text-xs font-medium uppercase" style="color: var(--admin-text-muted);">Details</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($customers as $c)
                        <tr class="border-b admin-row-hover" style="border-color: var(--admin-border);">
                            <td class="p-3 font-medium" style="color: var(--admin-text);">{{ $c->name }}</td>
                            <td class="p-3" style="color: var(--admin-text-muted);">{{ $c->email }}</td>
                            <td class="p-3 font-medium" style="color: var(--admin-text);">₹{{ number_format((float)($c->total_spend ?? 0), 2) }}</td>
                            <td class="p-3" style="color: var(--admin-text);">{{ (int)($c->order_count ?? 0) }}</td>
                            <td class="p-3" style="color: var(--admin-text-muted);">₹{{ number_format((float)($c->avg_order_value ?? 0), 2) }}</td>
                            <td class="p-3" style="color: var(--admin-text-muted);">
                                @if ($c->last_order_at)
                                    {{ is_object($c->last_order_at) ? $c->last_order_at->format('M d, Y') : \Carbon\Carbon::parse($c->last_order_at)->format('M d, Y') }}
                                @else
                                    —
                                @endif
                            </td>
                            <td class="p-3" style="color: var(--admin-text-muted);">
                                @if ($c->last_login)
                                    {{ $c->last_login->format('M d, Y') }}
                                @else
                                    —
                                @endif
                            </td>
                            <td class="p-3" style="color: var(--admin-text);">{{ (int)($c->loyalty_points ?? 0) }}</td>
                            <td class="p-3">
                                @php $st = $c->computed_status ?? 'inactive'; @endphp
                                <span class="px-2 py-0.5 text-xs rounded-full font-medium
                                    {{ $st === 'active' ? 'bg-emerald-500/20 text-emerald-400' : '' }}
                                    {{ $st === 'dormant' ? 'bg-amber-500/20 text-amber-400' : '' }}
                                    {{ $st === 'inactive' ? 'bg-gray-500/20 text-gray-400' : '' }}">
                                    {{ ucfirst($st) }}
                                </span>
                            </td>
                            <td class="p-3">
                                <a href="{{ route('admin.customers.show', $c) }}" class="font-medium transition hover:opacity-90" style="color: #60a5fa;">Details</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="p-8 text-center" style="color: var(--admin-text-muted);">No customers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>

            {{-- Mobile cards --}}
            <div class="md:hidden space-y-4">
                @foreach ($customers as $c)
                    <a href="{{ route('admin.customers.show', $c) }}" class="block p-4 rounded-lg transition" style="background: rgba(255,255,255,0.04); border: 1px solid var(--admin-border);">
                        <div class="flex justify-between items-start">
                            <span class="font-semibold" style="color: var(--admin-text);">{{ $c->name }}</span>
                            @php $st = $c->computed_status ?? 'inactive'; @endphp
                            <span class="px-2 py-0.5 text-xs rounded-full font-medium
                                {{ $st === 'active' ? 'bg-emerald-500/20 text-emerald-400' : '' }}
                                {{ $st === 'dormant' ? 'bg-amber-500/20 text-amber-400' : '' }}
                                {{ $st === 'inactive' ? 'bg-gray-500/20 text-gray-400' : '' }}">{{ ucfirst($st) }}</span>
                        </div>
                        <p class="text-sm mt-1" style="color: var(--admin-text-muted);">{{ $c->email }}</p>
                        <div class="flex justify-between text-sm mt-2" style="color: var(--admin-text-muted);">
                            <span>₹{{ number_format((float)($c->total_spend ?? 0), 2) }} · {{ (int)($c->order_count ?? 0) }} orders</span>
                            <span class="font-medium" style="color: var(--admin-text);">{{ (int)($c->loyalty_points ?? 0) }} pts</span>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-4">{{ $customers->links() }}</div>
        </div>
    </div>
</div>
@endsection
