<?php

namespace App\Filament\Resources\WarehouseLocations;

use App\Filament\Resources\WarehouseLocations\Pages\CreateWarehouseLocation;
use App\Filament\Resources\WarehouseLocations\Pages\EditWarehouseLocation;
use App\Filament\Resources\WarehouseLocations\Pages\ListWarehouseLocations;
use App\Filament\Resources\WarehouseLocations\Schemas\WarehouseLocationForm;
use App\Filament\Resources\WarehouseLocations\Tables\WarehouseLocationsTable;
use App\Models\WarehouseLocation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class WarehouseLocationResource extends Resource
{
    protected static ?string $model = WarehouseLocation::class;

    protected static bool $shouldRegisterNavigation = false;
    public static function form(Schema $schema): Schema
    {
        return WarehouseLocationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WarehouseLocationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWarehouseLocations::route('/'),
        ];
    }
}
