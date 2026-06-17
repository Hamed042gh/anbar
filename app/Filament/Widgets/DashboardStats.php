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

        return [
                Stat::make('ارزش کل موجودی', number_format(
                        Inventory::sum(DB::raw('quantity * avg_cost'))
                    ) . ' تومان')
                    ->descriptionIcon('heroicon-m-banknotes')
                    ->color('success'),

                Stat::make('کالاهای رو به اتمام', Inventory::join('product_variants', 'product_variants.id', '=', 'inventories.variant_id')
                        ->whereColumn('inventories.quantity', '<=', 'product_variants.reorder_level')
                        ->count())
                    ->description('نیاز به سفارش خرید')
                    ->descriptionIcon('heroicon-m-exclamation-triangle')
                    ->color('warning'),

                Stat::make('سفارش خرید در انتظار', PurchaseOrder::where('status', 'pending')->count())
                    ->descriptionIcon('heroicon-m-truck')
                    ->color('info'),

                Stat::make('فاکتورهای امروز', Invoice::whereDate('issued_at', today())->count())
                    ->description(number_format(Invoice::whereDate('issued_at', today())->sum('payable_amount')) . ' تومان فروش')
                    ->descriptionIcon('heroicon-m-receipt-percent')
                    ->color('primary'),
            ];
    }   
}