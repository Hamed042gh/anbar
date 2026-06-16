<?php

namespace App\Filament\Resources\ProductAttributeValues\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProductAttributeValueForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('attribute_id')
                    ->relationship('attribute', 'name')
                    ->required(),
                TextInput::make('value')
                    ->required(),
            ]);
    }
}
