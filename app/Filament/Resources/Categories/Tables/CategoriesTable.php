<?php

namespace App\Filament\Resources\Categories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('تصویر')
                    ->circular(),
                TextColumn::make('name')
                    ->label('نام')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('slug')
                    ->label('اسلاگ')
                    ->searchable()
                    ->color('gray')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('parent.name')
                    ->label('دسته والد')
                    ->placeholder('—')
                    ->badge()
                    ->color('info'),
                TextColumn::make('children_count')
                    ->label('زیردسته')
                    ->counts('children')
                    ->badge()
                    ->color('warning'),
                TextColumn::make('products_count')
                    ->label('محصولات')
                    ->counts('products')
                    ->badge()
                    ->color('success'),
                IconColumn::make('is_active')
                    ->label('وضعیت')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('تاریخ ایجاد')
                    ->dateTime('Y/m/d')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('وضعیت')
                    ->trueLabel('فعال')
                    ->falseLabel('غیرفعال')
                    ->placeholder('همه'),
                SelectFilter::make('parent_id')
                    ->label('دسته والد')
                    ->relationship('parent', 'name')
                    ->searchable()
                    ->preload()
                    ->placeholder('همه'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}