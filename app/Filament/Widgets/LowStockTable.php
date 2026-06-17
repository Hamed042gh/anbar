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
            ->paginated(false)
            ->striped()
            ->heading('🔴 کالاهای رو به اتمام')
            ->columns([
                TextColumn::make('variant.product.name')
                    ->label('کالا')
                    ->weight('bold')
                    ->icon('heroicon-m-cube')
                    ->iconColor('gray')
                    ->searchable(),

                TextColumn::make('variant.sku')
                    ->label('SKU')
                    ->badge()
                    ->color('gray')
                    ->copyable()
                    ->copyMessage('کپی شد'),

                TextColumn::make('warehouse.name')
                    ->label('انبار')
                    ->icon('heroicon-m-building-office')
                    ->iconColor('info'),

                TextColumn::make('quantity')
                    ->label('موجودی فعلی')
                    ->badge()
                    ->color(fn($state) => $state <= 0 ? 'danger' : 'warning')
                    ->formatStateUsing(fn($state) => $state <= 0 ? '🚨 صفر' : $state . ' عدد')
                    ->alignCenter(),

                TextColumn::make('variant.reorder_level')
                    ->label('حداقل موجودی')
                    ->badge()
                    ->color('gray')
                    ->suffix(' عدد')
                    ->alignCenter(),
            ]);
    }
}
