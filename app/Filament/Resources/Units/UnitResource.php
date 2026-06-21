<?php

namespace App\Filament\Resources\Units;

use App\Enums\NavigationGroup;
use App\Filament\Resources\Units\Pages\CreateUnit;
use App\Filament\Resources\Units\Pages\EditUnit;
use App\Filament\Resources\Units\Pages\ListUnits;
use App\Filament\Resources\Units\RelationManagers\ConversionsRelationManager;
use App\Filament\Resources\Units\Schemas\UnitForm;
use App\Filament\Resources\Units\Tables\UnitsTable;
use App\Models\Unit;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class UnitResource extends Resource
{
    protected static ?string $model = Unit::class;
    protected static string | UnitEnum | null $navigationGroup = NavigationGroup::Settings;
    protected static ?string $modelLabel = 'یکای اندازه';
    protected static ?string $pluralModelLabel = 'یکاهای اندازه';
    protected static ?string $navigationLabel = 'یکاهای اندازه';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return UnitForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UnitsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
           ConversionsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUnits::route('/'),
        ];
    }
}
