<?php

namespace App\Filament\Resources\UnitConversions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UnitConversionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('from_unit_id')
                    ->relationship('fromUnit', 'name')
                    ->required(),
                Select::make('to_unit_id')
                    ->relationship('toUnit', 'name')
                    ->required(),
                TextInput::make('factor')
                    ->required()
                    ->numeric(),
            ]);
    }
}
