<?php

namespace App\Filament\Resources\UnitConversions;

use App\Filament\Resources\UnitConversions\Pages\CreateUnitConversion;
use App\Filament\Resources\UnitConversions\Pages\EditUnitConversion;
use App\Filament\Resources\UnitConversions\Pages\ListUnitConversions;
use App\Filament\Resources\UnitConversions\Schemas\UnitConversionForm;
use App\Filament\Resources\UnitConversions\Tables\UnitConversionsTable;
use App\Models\UnitConversion;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UnitConversionResource extends Resource
{
    protected static ?string $model = UnitConversion::class;

    protected static bool $shouldRegisterNavigation = false;
    public static function form(Schema $schema): Schema
    {
        return UnitConversionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UnitConversionsTable::configure($table);
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
            'index' => ListUnitConversions::route('/'),
        ];
    }
}
