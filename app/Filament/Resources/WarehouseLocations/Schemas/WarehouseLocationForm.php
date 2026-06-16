<?php

namespace App\Filament\Resources\WarehouseLocations\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class WarehouseLocationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('warehouse_id')
                    ->relationship('warehouse', 'name')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('aisle'),
                TextInput::make('rack'),
                TextInput::make('shelf'),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
