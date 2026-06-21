<?php

namespace App\Filament\Resources\Customers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

class CustomersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('نام')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('type')
                    ->label('نوع')
                    ->badge(),
                TextColumn::make('phone')
                    ->label('تلفن')
                    ->searchable()
                    ->icon('heroicon-o-phone'),
                TextColumn::make('email')
                    ->label('ایمیل')
                    ->searchable()
                    ->icon('heroicon-o-envelope')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('credit_limit')
                    ->label('سقف اعتبار')
                    ->numeric()
                    ->sortable()
                    ->money('IRR'),
                TextColumn::make('balance')
                    ->label('مانده حساب')
                    ->numeric()
                    ->sortable()
                    ->money('IRR')
                    ->color(fn ($state) => $state < 0 ? 'danger' : 'success'),
                IconColumn::make('is_active')
                    ->label('وضعیت')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('تاریخ ایجاد')
                    ->dateTime('Y/m/d')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('province.name')
                    ->label('استان')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('city.name')
                    ->label('شهر')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('وضعیت')
                    ->trueLabel('فعال')
                    ->falseLabel('غیرفعال')
                    ->placeholder('همه'),
                SelectFilter::make('province_id')
                    ->label('استان')
                    ->relationship('province', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('city_id')
                    ->label('شهر')
                    ->relationship('city', 'name')
                    ->searchable()
                    ->preload(),
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}