<?php

namespace App\Filament\Resources\PurchaseReceiptItems\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PurchaseReceiptItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('purchase_receipt_id')
                    ->required()
                    ->numeric(),
                TextInput::make('purchase_order_item_id')
                    ->required()
                    ->numeric(),
                Select::make('variant_id')
                    ->relationship('variant', 'id')
                    ->required(),
                TextInput::make('quantity')
                    ->required()
                    ->numeric(),
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
