<?php

namespace App\Filament\Resources\StockMovements\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class StockMovementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('variant_id')
                    ->relationship('variant', 'id')
                    ->required(),
                Select::make('warehouse_id')
                    ->relationship('warehouse', 'name')
                    ->required(),
                Select::make('location_id')
                    ->relationship('location', 'name'),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('type')
                    ->options([
            'purchase' => 'Purchase',
            'sale' => 'Sale',
            'transfer_in' => 'Transfer in',
            'transfer_out' => 'Transfer out',
            'adjustment' => 'Adjustment',
            'return_in' => 'Return in',
            'return_out' => 'Return out',
        ])
                    ->required(),
                TextInput::make('quantity')
                    ->required()
                    ->numeric(),
                TextInput::make('unit_cost')
                    ->required()
                    ->numeric()
                    ->default(0.0)
                    ->prefix('$'),
                TextInput::make('referenceable_type')
                    ->required(),
                TextInput::make('referenceable_id')
                    ->required()
                    ->numeric(),
                Textarea::make('note')
                    ->columnSpanFull(),
            ]);
    }
}
