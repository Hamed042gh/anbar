<?php

namespace App\Filament\Resources\Inventories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class InventoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('variant.product.name')
                    ->label('محصول')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('warehouse.name')
                    ->label('انبار')
                    ->searchable()
                    ->badge()
                    ->color('info'),
                TextColumn::make('location.name')
                    ->label('موقعیت')
                    ->searchable()
                    ->placeholder('—'),
                TextColumn::make('quantity')
                    ->label('موجودی')
                    ->numeric(decimalPlaces: 3)
                    ->sortable()
                    ->color(fn ($state) => $state <= 0 ? 'danger' : 'success'),
                TextColumn::make('avg_cost')
                    ->label('میانگین بهای تمام‌شده')
                    ->numeric(decimalPlaces: 2)
                    ->sortable()
                    ->money('IRR'),
                TextColumn::make('updated_at')
                    ->label('آخرین بروزرسانی')
                    ->dateTime('Y/m/d')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('warehouse_id')
                    ->label('انبار')
                    ->relationship('warehouse', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('updated_at', 'desc');
    }
}