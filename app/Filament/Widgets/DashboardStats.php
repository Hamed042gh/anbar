<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\{Inventory, PurchaseOrder, Invoice};
use Illuminate\Support\Facades\DB;

class DashboardStats extends StatsOverviewWidget
{
    protected int|string|array $columnSpan = 'full';
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        $inventoryValue = Inventory::sum(DB::raw('quantity * avg_cost'));
        $lowStock = Inventory::join('product_variants', 'product_variants.id', '=', 'inventories.variant_id')
            ->whereColumn('inventories.quantity', '<=', 'product_variants.reorder_level')
            ->count();
        $pendingOrders = PurchaseOrder::whereIn('status', ['draft', 'sent', 'partial'])->count();
        $todayInvoices = Invoice::whereDate('issued_at', today());

        // فروش ۷ روز اخیر
        $salesChart = collect(range(6, 0))->map(fn($i) =>
            (int) Invoice::whereDate('issued_at', today()->subDays($i))
                ->where('status', 'confirmed')
                ->sum('payable_amount') / 1_000_000
        )->values()->toArray();

        // تعداد فاکتور ۷ روز اخیر
        $invoiceChart = collect(range(6, 0))->map(fn($i) =>
            Invoice::whereDate('issued_at', today()->subDays($i))->count()
        )->values()->toArray();

        // سفارش خرید ۷ روز اخیر
        $purchaseChart = collect(range(6, 0))->map(fn($i) =>
            PurchaseOrder::whereDate('created_at', today()->subDays($i))->count()
        )->values()->toArray();

        // موجودی کم ۷ روز (snapshot ثابته، نمودار صعودی نمایشی)
        $lowStockChart = collect(range(6, 0))->map(fn($i) =>
            Inventory::join('product_variants', 'product_variants.id', '=', 'inventories.variant_id')
                ->whereColumn('inventories.quantity', '<=', 'product_variants.reorder_level')
                ->count()
        )->values()->toArray();

        return [
            Stat::make('ارزش کل موجودی', number_format($inventoryValue) . ' تومان')
                ->description('مجموع دارایی انبار')
                ->descriptionIcon('heroicon-m-building-storefront')
                ->chart($salesChart)
                ->color('success'),

            Stat::make('کالاهای رو به اتمام', $lowStock . ' قلم')
                ->description($lowStock > 0 ? 'نیاز فوری به سفارش خرید' : 'موجودی همه کالاها کافیست')
                ->descriptionIcon($lowStock > 5 ? 'heroicon-m-fire' : 'heroicon-m-exclamation-triangle')
                ->chart($lowStockChart)
                ->color($lowStock > 5 ? 'danger' : 'warning'),

            Stat::make('سفارش‌های در جریان', $pendingOrders . ' سفارش')
                ->description('در انتظار دریافت کالا')
                ->descriptionIcon('heroicon-m-truck')
                ->chart($purchaseChart)
                ->color('info'),

            Stat::make('فاکتورهای امروز', $todayInvoices->count() . ' فاکتور')
                ->description(number_format($todayInvoices->sum('payable_amount')) . ' تومان فروش امروز')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart($invoiceChart)
                ->color('primary'),
        ];
    } 
}