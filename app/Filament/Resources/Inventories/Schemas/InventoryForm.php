<?php

namespace App\Filament\Resources\Inventories\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InventoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('مشخصات کالا')
                    ->schema([
                        Select::make('variant_id')
                            ->label('کالا')
                            ->relationship('variant', 'sku')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('warehouse_id')
                            ->label('انبار')
                            ->relationship('warehouse', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('location_id')
                            ->label('موقعیت در انبار')
                            ->relationship('location', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                    ])
                    ->columns(2),
                Section::make('اطلاعات مالی')
                    ->schema([
                        TextInput::make('quantity')
                            ->label('موجودی')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->minValue(0),
                        TextInput::make('avg_cost')
                            ->label('میانگین بهای تمام‌شده')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->suffix('ریال'),
                    ])
                    ->columns(2),
            ]);
    }
}