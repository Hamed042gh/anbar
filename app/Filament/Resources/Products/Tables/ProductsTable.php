<?php

namespace App\Filament\Resources\Products\Tables;

use App\Models\Product;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(
                Product::query()
                    ->with(['category', 'unit', 'media'])
                    ->withCount(['variants', 'barcodes'])
                    ->withMin('variants', 'price')
                    ->withMax('variants', 'price')
                    ->withExists([
                        'variants as has_default_variant' => fn(Builder $q) => $q->where('is_default', true),
                        'variants as has_low_stock' => fn(Builder $q) => $q->where('reorder_level', '>', 0),
                    ])
            )
            ->columns([
                ImageColumn::make('gallery')
                    ->state(fn(Product $r) => $r->getFirstMediaUrl('gallery'))
                    ->width(40)
                    ->height(40)
                    ->extraImgAttributes(['style' => 'border-radius:6px; object-fit:cover; cursor:pointer;'])
                    ->action(
                        Action::make('viewGallery')
                            ->modalHeading(fn(Product $r) => 'گالری — ' . $r->name)
                            ->modalContent(fn(Product $r) => view('filament.modals.product-gallery', [
                                'media' => $r->getMedia('gallery'),
                            ]))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('بستن')
                    ->closeModalByClickingAway(false)
                                ),

                TextColumn::make('name')
                    ->label('محصول')
                    ->searchable()
                    ->sortable()
                    ->description(fn(Product $r) => $r->sku)
                    ->weight('medium'),

                TextColumn::make('category.name')
                    ->label('دسته‌بندی')
                    ->badge()
                    ->color('info'),

                TextColumn::make('unit.name')
                    ->label('واحد')
                    ->badge()
                    ->color('gray'),

                TextColumn::make('variants_min_price')
                    ->label('قیمت')
                    ->formatStateUsing(function (Product $record) {
                        $min = number_format($record->variants_min_price);
                        $max = number_format($record->variants_max_price);
                        if ($min === $max) return $min . ' ت';
                        return $min . ' — ' . $max . ' ت';
                    })
                    ->sortable(),

                TextColumn::make('variants_count')
                    ->label('variants')
                    ->badge()
                    ->color(fn(Product $r) => $r->variants_count > 1 ? 'success' : 'gray')
                    ->sortable(),

                TextColumn::make('barcodes_count')
                    ->label('barcodes')
                    ->badge()
                    ->color(fn(Product $r) => $r->barcodes_count > 0 ? 'info' : 'danger')
                    ->sortable(),

                TextColumn::make('type')
                    ->label('نوع')
                    ->badge()
                    ->color(fn(string $state) => match ($state) {
                        'simple'   => 'warning',
                        'variable' => 'success',
                        default    => 'gray',
                    }),

                IconColumn::make('is_active')
                    ->label('فعال')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('ایجاد')
                    ->dateTime('Y/m/d')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('deleted_at')
                    ->label('حذف')
                    ->dateTime('Y/m/d')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
                TernaryFilter::make('is_active')->label('وضعیت'),
                SelectFilter::make('type')
                    ->label('نوع')
                    ->options([
                        'simple'   => 'Simple',
                        'variable' => 'Variable',
                    ]),
                SelectFilter::make('category')
                    ->label('دسته‌بندی')
                    ->relationship('category', 'name'),
            ])
            ->recordActions([
                 EditAction::make()->modal(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped();
    }
}