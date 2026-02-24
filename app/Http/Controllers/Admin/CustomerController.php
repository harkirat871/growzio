<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\CustomerAnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CustomerController extends Controller
{
    public function __construct(
        protected CustomerAnalyticsService $analytics
    ) {}

    public function index(Request $request): View
    {
        $search = $request->get('search');
        $sortBy = $request->get('sort', 'total_spend');
        $sortDir = $request->get('dir', 'desc');
        $filter = $request->get('filter');

        $perPage = $filter === 'top_10' ? 10 : 20;
        $customers = $this->analytics->getCustomersList($search, $sortBy, $sortDir, $filter, $perPage);

        foreach ($customers as $c) {
            $c->computed_status = $this->analytics->getCustomerStatus(
                $c->last_order_at ? (is_string($c->last_order_at) ? $c->last_order_at : $c->last_order_at->toDateTimeString()) : null
            );
        }

        return view('admin.customers.index', compact('customers', 'search', 'sortBy', 'sortDir', 'filter'));
    }

    public function show(User $customer, Request $request): View
    {
        if ($customer->isAdmin()) {
            abort(404, 'Admin users are not treated as customers.');
        }

        $analytics = $this->analytics->getCustomerAnalytics($customer);

        $analytics['chart_order_freq'] = $this->analytics->getOrderFrequencyChartData($analytics['orders']);
        $analytics['chart_orders_revenue'] = $this->analytics->getOrdersVsRevenueChartData($analytics['orders']);
        $analytics['chart_category'] = $this->analytics->getCategoryDistributionChartData($analytics['orders']);
        $analytics['chart_loyalty'] = $this->analytics->getLoyaltyTrendChartData($analytics['orders'], $analytics['loyalty']['current_points']);

        $purchaseHistory = $customer->orders()
            ->with(['items.product'])
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.customers.show', compact('analytics', 'purchaseHistory'));
    }

    public function exportCsv(Request $request): StreamedResponse
    {
        $filter = $request->get('filter');
        $csv = $this->analytics->exportCustomersCsv($filter);

        return response()->streamDownload(function () use ($csv) {
            echo $csv;
        }, 'customers-analytics-' . now()->format('Y-m-d-His') . '.csv', [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="customers-analytics-' . now()->format('Y-m-d-His') . '.csv"',
        ]);
    }

    public function exportCustomerSummary(User $customer): StreamedResponse
    {
        if ($customer->isAdmin()) {
            abort(404);
        }
        $csv = $this->analytics->exportCustomerSummaryCsv($customer);
        $name = 'customer-' . $customer->id . '-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($csv) {
            echo $csv;
        }, $name, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $name . '"',
        ]);
    }
}
