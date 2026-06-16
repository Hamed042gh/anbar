<?php

namespace App\Filament\Resources\InventoryCheckItems\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class InventoryCheckItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('inventory_check_id')
                    ->relationship('inventoryCheck', 'id')
                    ->required(),
                Select::make('variant_id')
                    ->relationship('variant', 'id')
                    ->required(),
                TextInput::make('system_quantity')
                    ->required()
                    ->numeric(),
                TextInput::make('actual_quantity')
                    ->required()
                    ->numeric(),
                TextInput::make('difference')
                    ->numeric(),
                Textarea::make('note')
                    ->columnSpanFull(),
            ]);
    }
}
