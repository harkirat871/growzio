<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CustomerAnalyticsService
{
    /**
     * Get paginated list of customers with aggregated metrics (optimized, no N+1).
     */
    public function getCustomersList(
        ?string $search = null,
        ?string $sortBy = 'total_spend',
        string $sortDir = 'desc',
        ?string $filter = null,
        int $perPage = 20
    ) {
        $baseQuery = User::query()
            ->where(function (Builder $q) {
                $q->where('is_admin', false)->orWhereNull('is_admin');
            })
            ->whereRaw('(role IS NULL OR role != ?)', ['admin']);

        $query = $this->applyAggregatesForList($baseQuery);

        if ($search) {
            $term = '%' . $search . '%';
            $query->where(function (Builder $q) use ($term) {
                $q->where('name', 'like', $term)
                    ->orWhere('email', 'like', $term);
            });
        }

        $this->applyListFilter($query, $filter);
        $this->applyListSort($query, $sortBy, $sortDir);

        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Apply subqueries/aggregates for the list view.
     */
    protected function applyAggregatesForList(Builder $query): Builder
    {
        $query->select([
            'users.*',
            DB::raw('COALESCE(ord.total_spend, 0) as total_spend'),
            DB::raw('COALESCE(ord.order_count, 0) as order_count'),
            DB::raw('COALESCE(ord.avg_order_value, 0) as avg_order_value'),
            DB::raw('ord.last_order_at as last_order_at'),
        ])->leftJoinSub(
            Order::query()
                ->whereNotNull('user_id')
                ->selectRaw('user_id, SUM(total) as total_spend, COUNT(*) as order_count, AVG(total) as avg_order_value, MAX(created_at) as last_order_at')
                ->groupBy('user_id'),
            'ord',
            'users.id',
            '=',
            'ord.user_id'
        );

        return $query;
    }

    protected function applyListFilter(Builder $query, ?string $filter): void
    {
        if (!$filter) return;

        switch ($filter) {
            case 'active_30':
                $query->whereRaw('ord.last_order_at >= ?', [now()->subDays(30)]);
                break;
            case 'no_orders_60':
                $query->where(function (Builder $q) {
                    $q->whereNull('ord.last_order_at')
                        ->orWhereRaw('ord.last_order_at < ?', [now()->subDays(60)]);
                });
                break;
            case 'top_10':
                $query->orderByDesc(DB::raw('COALESCE(ord.total_spend, 0)'));
                break;
            case 'high_loyalty':
                $query->where('users.loyalty_points', '>=', 100);
                break;
        }
    }

    protected function applyListSort(Builder $query, string $sortBy, string $sortDir): void
    {
        $dir = strtolower($sortDir) === 'asc' ? 'asc' : 'desc';
        switch ($sortBy) {
            case 'total_spend':
                $query->orderBy(DB::raw('COALESCE(ord.total_spend, 0)'), $dir);
                break;
            case 'order_count':
            case 'total_orders':
                $query->orderBy(DB::raw('COALESCE(ord.order_count, 0)'), $dir);
                break;
            case 'last_login':
                $query->orderBy('users.last_login', $dir);
                break;
            case 'loyalty_points':
                $query->orderBy('users.loyalty_points', $dir);
                break;
            case 'last_order':
                $query->orderByRaw('ord.last_order_at ' . $dir . ' NULLS LAST');
                break;
            default:
                $query->orderBy(DB::raw('COALESCE(ord.total_spend, 0)'), 'desc');
        }
    }

    /**
     * Compute customer status: Active, Dormant, Inactive.
     */
    public function getCustomerStatus(?string $lastOrderAt): string
    {
        if (!$lastOrderAt) return 'inactive';
        $days = now()->diffInDays(\Carbon\Carbon::parse($lastOrderAt), false);
        if ($days <= 30) return 'active';
        if ($days <= 90) return 'dormant';
        return 'inactive';
    }

    /**
     * Full analytics for a single customer (detail page).
     */
    public function getCustomerAnalytics(User $user): array
    {
        $orders = Order::where('user_id', $user->id)
            ->with(['items.product.category', 'items.product.category2', 'items.product.category3', 'items.product.category4'])
            ->orderBy('created_at')
            ->get();

        $totalSpend = $orders->sum('total');
        $orderCount = $orders->count();
        $avgOrderValue = $orderCount > 0 ? $totalSpend / $orderCount : 0;
        $highestOrder = $orders->max('total') ?? 0;

        $lastOrder = $orders->last();
        $lastOrderAt = $lastOrder?->created_at;
        $daysSinceLastOrder = $lastOrderAt ? now()->diffInDays($lastOrderAt, false) : null;

        $ordersLast30 = $orders->filter(fn ($o) => $o->created_at >= now()->subDays(30))->count();
        $ordersLast90 = $orders->filter(fn ($o) => $o->created_at >= now()->subDays(90))->count();

        $orderDates = $orders->pluck('created_at')->filter()->sort();
        $avgDaysBetween = 0;
        if ($orderDates->count() >= 2) {
            $diffs = [];
            $prev = null;
            foreach ($orderDates as $d) {
                if ($prev) $diffs[] = $prev->diffInDays($d);
                $prev = $d;
            }
            $avgDaysBetween = count($diffs) > 0 ? array_sum($diffs) / count($diffs) : 0;
        }

        $lifetimePointsUsed = $orders->sum('loyalty_points_used');
        $lifetimePointsEarned = (int) $user->loyalty_points + (int) $lifetimePointsUsed;
        $redemptionRate = $lifetimePointsEarned > 0
            ? round(100 * $lifetimePointsUsed / $lifetimePointsEarned, 1)
            : 0;
        $avgPointsPerOrder = $orderCount > 0 ? round($lifetimePointsUsed / $orderCount, 1) : 0;

        $categoryCounts = [];
        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                $product = $item->product;
                $cats = array_filter([
                    $product?->category?->name,
                    $product?->category2?->name,
                    $product?->category3?->name,
                    $product?->category4?->name,
                ]);
                foreach ($cats as $cat) {
                    if ($cat) {
                        $categoryCounts[$cat] = ($categoryCounts[$cat] ?? 0) + (int) $item->quantity;
                    }
                }
            }
        }
        arsort($categoryCounts);
        $mostPurchasedCategory = array_key_first($categoryCounts) ?? null;

        $storeTotal = Order::sum('total');
        $contributionPct = $storeTotal > 0 ? round(100 * $totalSpend / $storeTotal, 2) : 0;

        $referralCount = 0;
        if ($user->email) {
            $referralCount = User::where('referred_by', $user->email)->count();
        }
        if ($referralCount === 0 && $user->name) {
            $referralCount = User::where('referred_by', $user->name)->count();
        }

        $sessionCount30 = DB::table('sessions')
            ->where('user_id', $user->id)
            ->where('last_activity', '>=', now()->subDays(30)->timestamp)
            ->count();

        return [
            'user' => $user,
            'orders' => $orders,
            'revenue' => [
                'lifetime_spend' => $totalSpend,
                'total_orders' => $orderCount,
                'avg_order_value' => $avgOrderValue,
                'highest_order' => $highestOrder,
                'orders_last_30' => $ordersLast30,
                'orders_last_90' => $ordersLast90,
            ],
            'retention' => [
                'account_created' => $user->created_at,
                'last_login' => $user->last_login,
                'login_count_30' => $sessionCount30,
                'days_since_last_order' => $daysSinceLastOrder,
                'avg_days_between_orders' => round($avgDaysBetween, 1),
            ],
            'loyalty' => [
                'current_points' => (int) ($user->loyalty_points ?? 0),
                'lifetime_earned' => $lifetimePointsEarned,
                'lifetime_redeemed' => (int) $lifetimePointsUsed,
                'redemption_rate_pct' => $redemptionRate,
                'avg_points_per_order' => $avgPointsPerOrder,
            ],
            'behavioral' => [
                'most_purchased_category' => $mostPurchasedCategory,
                'referral_count' => $referralCount,
                'contribution_pct' => $contributionPct,
            ],
            'status' => $this->getCustomerStatus($lastOrderAt?->toDateTimeString()),
        ];
    }

    /**
     * Chart data: order frequency over time (monthly).
     */
    public function getOrderFrequencyChartData(Collection $orders): array
    {
        $byMonth = $orders->groupBy(fn ($o) => $o->created_at->format('Y-m'));
        $months = collect($byMonth->keys())->sort()->values();
        $counts = $months->map(fn ($m) => $byMonth[$m]->count())->values();
        return [
            'labels' => $months->map(fn ($m) => \Carbon\Carbon::parse($m . '-01')->format('M Y'))->toArray(),
            'data' => $counts->toArray(),
        ];
    }

    /**
     * Chart data: orders vs revenue (monthly).
     */
    public function getOrdersVsRevenueChartData(Collection $orders): array
    {
        $byMonth = $orders->groupBy(fn ($o) => $o->created_at->format('Y-m'));
        $months = collect($byMonth->keys())->sort()->values();
        return [
            'labels' => $months->map(fn ($m) => \Carbon\Carbon::parse($m . '-01')->format('M Y'))->toArray(),
            'orders' => $months->map(fn ($m) => $byMonth[$m]->count())->toArray(),
            'revenue' => $months->map(fn ($m) => round($byMonth[$m]->sum('total'), 2))->toArray(),
        ];
    }

    /**
     * Chart data: category distribution (pie).
     */
    public function getCategoryDistributionChartData(Collection $orders): array
    {
        $categoryTotals = [];
        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                $product = $item->product;
                $cats = array_filter([
                    $product?->category?->name,
                    $product?->category2?->name,
                    $product?->category3?->name,
                    $product?->category4?->name,
                ]);
                foreach ($cats as $cat) {
                    if ($cat) {
                        $categoryTotals[$cat] = ($categoryTotals[$cat] ?? 0) + (float) $item->subtotal;
                    }
                }
            }
        }
        arsort($categoryTotals);
        return [
            'labels' => array_keys($categoryTotals),
            'data' => array_values($categoryTotals),
        ];
    }

    /**
     * Chart data: loyalty points earned vs redeemed trend (by order).
     */
    public function getLoyaltyTrendChartData(Collection $orders, int $currentPoints): array
    {
        $cumulativeEarned = 0;
        $cumulativeRedeemed = 0;
        $labels = [];
        $earned = [];
        $redeemed = [];
        foreach ($orders->sortBy('created_at') as $i => $o) {
            $used = (int) ($o->loyalty_points_used ?? 0);
            $redeemedVal = (float) ($o->loyalty_discount_amount ?? 0);
            $cumulativeRedeemed += $used;
            $estEarned = (float) $o->total * 0.01;
            $cumulativeEarned += (int) round($estEarned);
            $labels[] = $o->created_at->format('M d, Y');
            $earned[] = $cumulativeEarned;
            $redeemed[] = $cumulativeRedeemed;
        }
        return [
            'labels' => $labels,
            'earned' => $earned,
            'redeemed' => $redeemed,
        ];
    }

    /**
     * Export customer list as CSV.
     */
    public function exportCustomersCsv(?string $filter = null): string
    {
        $query = User::query()
            ->where('role', '!=', 'admin')
            ->where(function (Builder $q) {
                $q->whereNull('role')->orWhere('role', 'user')->orWhere('role', 'seller');
            });
        $query = $this->applyAggregatesForList($query);
        $this->applyListFilter($query, $filter);
        $customers = $query->orderByDesc(DB::raw('COALESCE(ord.total_spend, 0)'))->get();

        $rows = [['Name', 'Email', 'Total Spend', 'Total Orders', 'Avg Order Value', 'Last Order', 'Last Login', 'Loyalty Points', 'Status']];
        foreach ($customers as $u) {
            $status = $this->getCustomerStatus($u->last_order_at);
            $rows[] = [
                $u->name,
                $u->email,
                number_format((float) ($u->total_spend ?? 0), 2),
                (int) ($u->order_count ?? 0),
                number_format((float) ($u->avg_order_value ?? 0), 2),
                $u->last_order_at ? $u->last_order_at : '',
                $u->last_login ? $u->last_login->format('Y-m-d H:i') : '',
                (int) ($u->loyalty_points ?? 0),
                ucfirst($status),
            ];
        }
        $out = fopen('php://temp', 'r+');
        foreach ($rows as $row) {
            fputcsv($out, $row);
        }
        rewind($out);
        return stream_get_contents($out);
    }

    /**
     * Export single customer analytics as CSV summary.
     */
    public function exportCustomerSummaryCsv(User $user): string
    {
        $a = $this->getCustomerAnalytics($user);
        $r = $a['revenue'];
        $ret = $a['retention'];
        $loy = $a['loyalty'];
        $beh = $a['behavioral'];

        $rows = [
            ['Customer Analytics Summary', $user->name, $user->email],
            [],
            ['Revenue', ''],
            ['Lifetime Spend', '₹' . number_format($r['lifetime_spend'], 2)],
            ['Total Orders', $r['total_orders']],
            ['Avg Order Value', '₹' . number_format($r['avg_order_value'], 2)],
            ['Highest Order', '₹' . number_format($r['highest_order'], 2)],
            ['Orders (30d)', $r['orders_last_30']],
            ['Orders (90d)', $r['orders_last_90']],
            [],
            ['Retention', ''],
            ['Account Created', $ret['account_created']?->format('Y-m-d') ?? '—'],
            ['Last Login', $ret['last_login']?->format('Y-m-d H:i') ?? '—'],
            ['Logins (30d)', $ret['login_count_30']],
            ['Days Since Last Order', $ret['days_since_last_order'] ?? '—'],
            ['Avg Days Between Orders', $ret['avg_days_between_orders'] ?: '—'],
            [],
            ['Loyalty', ''],
            ['Current Points', $loy['current_points']],
            ['Lifetime Earned', $loy['lifetime_earned']],
            ['Lifetime Redeemed', $loy['lifetime_redeemed']],
            ['Redemption Rate %', $loy['redemption_rate_pct']],
            [],
            ['Behavioral', ''],
            ['Top Category', $beh['most_purchased_category'] ?? '—'],
            ['Referral Count', $beh['referral_count']],
            ['Revenue Share %', $beh['contribution_pct']],
        ];

        $out = fopen('php://temp', 'r+');
        foreach ($rows as $row) {
            fputcsv($out, $row);
        }
        rewind($out);
        return stream_get_contents($out);
    }
}
