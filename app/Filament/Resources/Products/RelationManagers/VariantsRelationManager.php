<?php

namespace App\Filament\Resources\Products\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class VariantsRelationManager extends RelationManager
{
    protected static string $relationship = 'variants';
    protected static ?string $title = 'Variants';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('اطلاعات')
                    ->columns(2)
                    ->schema([
                        TextInput::make('sku')
                            ->label('SKU')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->columnSpanFull(),

                        TextInput::make('price')
                            ->label('قیمت فروش')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->prefix('﷼')
                            ->minValue(0),

                        TextInput::make('cost_price')
                            ->label('قیمت خرید')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->prefix('﷼')
                            ->minValue(0),

                        TextInput::make('reorder_level')
                            ->label('حداقل موجودی')
                            ->numeric()
                            ->default(10)
                            ->minValue(0),
                    ]),

                Section::make('وضعیت')
                    ->columns(2)
                    ->schema([
                        Toggle::make('is_default')
                            ->label('variant پیش‌فرض')
                            ->onColor('success'),

                        Toggle::make('is_active')
                            ->label('فعال')
                            ->default(true)
                            ->onColor('success')
                            ->offColor('danger'),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('sku')
            ->columns([
                TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('کپی شد'),

                TextColumn::make('price')
                    ->label('قیمت فروش')
                    ->numeric(thousandsSeparator: ',')
                    ->suffix(' ﷼')
                    ->sortable(),

                TextColumn::make('cost_price')
                    ->label('قیمت خرید')
                    ->numeric(thousandsSeparator: ',')
                    ->suffix(' ﷼')
                    ->sortable(),

                TextColumn::make('reorder_level')
                    ->label('حداقل موجودی')
                    ->badge()
                    ->color(fn($state) => $state <= 5 ? 'danger' : 'gray'),

                IconColumn::make('is_default')
                    ->label('پیش‌فرض')
                    ->boolean(),

                IconColumn::make('is_active')
                    ->label('فعال')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('ایجاد')
                    ->dateTime('Y/m/d')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
                ForceDeleteAction::make(),
                RestoreAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}