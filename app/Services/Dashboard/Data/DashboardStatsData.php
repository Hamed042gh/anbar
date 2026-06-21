<?php

namespace App\Services\Dashboard\Data;

final readonly class DashboardStatsData
{
    public function __construct(
        public float $inventoryValue,
        public int $lowStockCount,
        public int $lowStockRatio,
        public int $pendingOrdersCount,
        public array $pendingByStatus,
        public int $todayInvoiceCount,
        public float $todayInvoiceSum,
        public ?float $salesTrendPercent,
        public int $todayBarPercent,
        public int $yesterdayBarPercent,
    ) {}
}
