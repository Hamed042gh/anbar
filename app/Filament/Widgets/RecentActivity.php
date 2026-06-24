<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\{StockMovement, Invoice};
use Illuminate\Support\Collection;

class RecentActivity extends Widget
{
    protected string $view = 'filament.widgets.recent-activity';
    protected ?string $pollingInterval = '15s';
    protected int|string|array $columnSpan = 2;
    protected static ?int $sort = 3;

    public function getActivities(): Collection
    {
        $movements = StockMovement::with('variant.product')
            ->latest()
            ->limit(8)
            ->get()
            ->map(fn($m) => [
                'icon' => match($m->type) {
                    'purchase'     => 'heroicon-o-arrow-down-tray',
                    'sale'         => 'heroicon-o-arrow-up-tray',
                    'transfer_in'  => 'heroicon-o-arrows-right-left',
                    'transfer_out' => 'heroicon-o-arrows-right-left',
                    'adjustment'   => 'heroicon-o-adjustments-horizontal',
                    'return_in'    => 'heroicon-o-arrow-uturn-left',
                    'return_out'   => 'heroicon-o-arrow-uturn-right',
                    default        => 'heroicon-o-circle-stack',
                },
                'color' => match($m->type) {
                    'purchase', 'return_in', 'transfer_in' => 'success',
                    'sale', 'return_out', 'transfer_out'   => 'danger',
                    default                                 => 'warning',
                },
                'label' => match($m->type) {
                    'purchase'     => 'رسید خرید',
                    'sale'         => 'فروش',
                    'transfer_in'  => 'انتقال ورودی',
                    'transfer_out' => 'انتقال خروجی',
                    'adjustment'   => 'تعدیل',
                    'return_in'    => 'مرجوعی ورودی',
                    'return_out'   => 'مرجوعی خروجی',
                    default        => 'حرکت',
                },
                'text' => ($m->variant?->product?->name ?? 'کالا') . ' — ' . number_format($m->quantity) . ' عدد',
                'time' => $m->created_at,
            ]);

        $invoices = Invoice::latest('issued_at')
            ->limit(12)
            ->get()
            ->map(fn($i) => [
                'icon'  => match($i->status) {
                    'confirmed'  => 'heroicon-o-check-circle',
                    'cancelled'  => 'heroicon-o-x-circle',
                    default      => 'heroicon-o-clock',
                },
                'color' => match($i->status) {
                    'confirmed' => 'primary',
                    'cancelled' => 'danger',
                    default     => 'warning',
                },
                'label' => 'فاکتور فروش',
                'text'  => 'فاکتور #' . $i->number . ' — ' . number_format($i->payable_amount) . ' تومان',
                'time'  => $i->issued_at,
            ]);

        return $movements->concat($invoices)
            ->sortByDesc('time')
            ->take(15)
            ->values();
    }
}
