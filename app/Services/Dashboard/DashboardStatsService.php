<?php

namespace App\Services\Dashboard;

use App\Models\{Inventory, PurchaseOrder, Invoice};
use App\Services\Dashboard\Data\DashboardStatsData;
use Illuminate\Support\Facades\{DB, Cache};
use Illuminate\Support\Collection;

class DashboardStatsService
{
    private const CACHE_KEY = 'dashboard-stats';
    private const CACHE_TTL_MINUTES = 5;
public function get(): DashboardStatsData
{
    try {
        $data = Cache::remember(
            self::CACHE_KEY,
            now()->addMinutes(self::CACHE_TTL_MINUTES),
            fn () => $this->buildArray(),
        );

        return new DashboardStatsData(...$data);
    } catch (\Throwable $e) {
        \Log::error('DashboardStats failed: ' . $e->getMessage(), ['exception' => $e]);
        throw $e;
    }
}

    private function buildArray(): array
    {
        $start = today()->subDays(6);

        [$todayCount, $todaySum, $yesterdaySum] = $this->todayInvoiceFigures();

        $salesByDay = $this->groupedSums(
            Invoice::where('status', 'confirmed'), 'issued_at', 'payable_amount', $start
        );
        $lowStockCount = $this->lowStockCount();
[$todayBarPct, $yesterdayBarPct] = $this->barPercentages($todaySum, $yesterdaySum);

return [
    'inventoryValue' => $this->inventoryValue(),
    'lowStockCount' => $lowStockCount,
    'lowStockRatio' => $this->lowStockRatio($lowStockCount),
    'pendingOrdersCount' => $this->pendingOrdersCount(),
    'pendingByStatus' => $this->pendingByStatus(),
    'todayInvoiceCount' => $todayCount,
    'todayInvoiceSum' => $todaySum,
    'salesTrendPercent' => $this->trendPercent($todaySum, $yesterdaySum),
    'todayBarPercent' => $todayBarPct,
    'yesterdayBarPercent' => $yesterdayBarPct,
];

    }

    private function inventoryValue(): float
    {
        return (float) Inventory::sum(DB::raw('quantity * avg_cost'));
    }

    private function lowStockCount(): int
    {
        return Inventory::join('product_variants', 'product_variants.id', '=', 'inventories.variant_id')
            ->whereColumn('inventories.quantity', '<=', 'product_variants.reorder_level')
            ->count();
    }

    private function pendingOrdersCount(): int
    {
        return PurchaseOrder::whereIn('status', ['draft', 'sent', 'partial'])->count();
    }

    private function todayInvoiceFigures(): array
    {
        $count = Invoice::whereDate('issued_at', today())->count();
        $sum = (float) Invoice::whereDate('issued_at', today())->sum('payable_amount');
        $yesterdaySum = (float) Invoice::whereDate('issued_at', today()->subDay())
            ->where('status', 'confirmed')->sum('payable_amount');

        return [$count, $sum, $yesterdaySum];
    }

    private function groupedSums($query, string $dateColumn, string $sumColumn, $start): Collection
    {
        return $query->whereBetween($dateColumn, [$start, today()->endOfDay()])
            ->selectRaw("DATE($dateColumn) as d, SUM($sumColumn) as total")
            ->groupBy('d')->pluck('total', 'd');
    }

    private function groupedCounts($query, string $dateColumn, $start): Collection
    {
        return $query->whereBetween($dateColumn, [$start, today()->endOfDay()])
            ->selectRaw("DATE($dateColumn) as d, COUNT(*) as total")
            ->groupBy('d')->pluck('total', 'd');
    }

    private function fillDays(Collection $byDay, int $divideBy = 1): array
    {
        return collect(range(6, 0))
            ->map(fn ($i) => round(($byDay[today()->subDays($i)->toDateString()] ?? 0) / $divideBy, 1))
            ->values()->toArray();
    }

    private function trendPercent(float $today, float $yesterday): ?float
    {
        if ($yesterday <= 0) {
            return null;
        }

        return round((($today - $yesterday) / $yesterday) * 100, 1);
    }

    private function lowStockRatio(int $lowStockCount): int
{
    $total = Inventory::count();
    return $total > 0 ? (int) round(min($lowStockCount / $total * 100, 100)) : 0;
}

private function pendingByStatus(): array
{
    return PurchaseOrder::whereIn('status', ['draft', 'sent', 'partial'])
        ->selectRaw('status, COUNT(*) as total')
        ->groupBy('status')
        ->pluck('total', 'status')
        ->toArray();
}

private function barPercentages(float $today, float $yesterday): array
{
    $max = max($today, $yesterday, 1);
    return [
        (int) round($today / $max * 100),
        (int) round($yesterday / $max * 100),
    ];
}
}
