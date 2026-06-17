<?php

namespace App\Filament\Widgets;

use Filament\Widgets\TableWidget;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use App\Models\Inventory;

class LowStockTable extends TableWidget
{
    protected int|string|array $columnSpan = 2;
    protected static ?int $sort = 3;
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Inventory::query()
                    ->join('product_variants', 'product_variants.id', '=', 'inventories.variant_id')
                    ->whereColumn('inventories.quantity', '<=', 'product_variants.reorder_level')
                    ->with(['variant.product', 'warehouse'])
                    ->select('inventories.*')
            )
            ->columns([
                TextColumn::make('variant.product.name')->label('کالا'),
                TextColumn::make('variant.sku')->label('تنوع/SKU'),
                TextColumn::make('warehouse.name')->label('انبار'),
                TextColumn::make('quantity')->label('موجودی')->badge()->color('danger'),
            ]);
    }
}
