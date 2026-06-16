<?php

namespace App\Filament\Resources\PurchaseOrderItems\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PurchaseOrderItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('purchase_order_id')
                    ->relationship('purchaseOrder', 'id')
                    ->required(),
                Select::make('variant_id')
                    ->relationship('variant', 'id')
                    ->required(),
                TextInput::make('quantity')
                    ->required()
                    ->numeric(),
                TextInput::make('received_quantity')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('unit_cost')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('total_cost')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
            ]);
    }
}
