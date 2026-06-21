<?php

namespace App\Filament\Widgets;

use App\Models\Inventory;
use Filament\Widgets\Widget;

class CriticalStockAlert extends Widget
{
    protected string $view = 'filament.widgets.critical-stock-alert';
    protected int|string|array $columnSpan = 'full';
    protected static ?int $sort = 0;
    protected ?string $pollingInterval = '30s';

    public static function canView(): bool
    {
        return static::criticalItems()->exists();
    }

    protected static function criticalItems()
    {
        return Inventory::query()
            ->join('product_variants', 'product_variants.id', '=', 'inventories.variant_id')
            ->where('inventories.quantity', '<=', 0)
            ->with(['variant.product', 'warehouse'])
            ->select('inventories.*');
    }

    protected function getViewData(): array
    {
        return ['items' => static::criticalItems()->get()];
    }
}
