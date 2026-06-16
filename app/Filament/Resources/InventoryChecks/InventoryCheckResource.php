<?php

namespace App\Filament\Resources\InventoryChecks;

use App\Enums\NavigationGroup;
use App\Filament\Resources\InventoryChecks\Pages\CreateInventoryCheck;
use App\Filament\Resources\InventoryChecks\Pages\EditInventoryCheck;
use App\Filament\Resources\InventoryChecks\Pages\ListInventoryChecks;
use App\Filament\Resources\InventoryChecks\Schemas\InventoryCheckForm;
use App\Filament\Resources\InventoryChecks\Tables\InventoryChecksTable;
use App\Filament\Resources\InventoryChecks\RelationManagers\ItemsRelationManager;
use App\Models\InventoryCheck;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class InventoryCheckResource extends Resource
{
    protected static ?string $model = InventoryCheck::class;

    protected static string | UnitEnum | null $navigationGroup = NavigationGroup::Warehouse;
    protected static ?string $modelLabel = 'کنترل موجودی';
    protected static ?string $pluralModelLabel = 'کنترل موجودی';
    protected static ?string $navigationLabel = 'کنترل موجودی';
    protected static ?int $navigationSort = 3;
    public static function form(Schema $schema): Schema
    {
        return InventoryCheckForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InventoryChecksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ItemsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInventoryChecks::route('/'),
            'create' => CreateInventoryCheck::route('/create'),
            'edit' => EditInventoryCheck::route('/{record}/edit'),
        ];
    }
}
