<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\{StockMovement, Invoice};
use Illuminate\Support\Collection;

class RecentActivity extends Widget
{
    protected string $view = 'filament.widgets.recent-activity';
    protected ?string $pollingInterval = '15s';
    protected int|string|array $columnSpan = 1;
    protected static ?int $sort = 3;

    public function getActivities(): Collection
    {
        $movements = StockMovement::with('variant.product')
            ->latest()
            ->limit(5)
            ->get()
            ->map(fn ($m) => [
                'icon' => $m->type === 'in' ? 'heroicon-o-arrow-down-tray' : 'heroicon-o-arrow-up-tray',
                'color' => $m->type === 'in' ? 'success' : 'danger',
                'text' => ($m->variant->product->name ?? 'کالا') . ' - ' . $m->quantity . ' عدد',
                'time' => $m->created_at,
            ]);

        $invoices = Invoice::latest('issued_at')
            ->limit(5)
            ->get()
            ->map(fn ($i) => [
                'icon' => 'heroicon-o-receipt-percent',
                'color' => 'primary',
                'text' => 'فاکتور #' . $i->number . ' - ' . number_format($i->payable_amount) . ' تومان',
                'time' => $i->issued_at,
            ]);

        return $movements->concat($invoices)->sortByDesc('time')->take(8)->values();
    }
}
