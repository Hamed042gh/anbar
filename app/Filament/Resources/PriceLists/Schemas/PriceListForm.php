<?php

namespace App\Filament\Resources\PriceLists\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PriceListForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Select::make('type')
                    ->options(['retail' => 'Retail', 'wholesale' => 'Wholesale', 'vip' => 'Vip'])
                    ->default('retail')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
