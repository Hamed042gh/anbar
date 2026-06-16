<?php

namespace App\Filament\Resources\InventoryCheckItems;

use App\Filament\Resources\InventoryCheckItems\Pages\CreateInventoryCheckItem;
use App\Filament\Resources\InventoryCheckItems\Pages\EditInventoryCheckItem;
use App\Filament\Resources\InventoryCheckItems\Pages\ListInventoryCheckItems;
use App\Filament\Resources\InventoryCheckItems\Schemas\InventoryCheckItemForm;
use App\Filament\Resources\InventoryCheckItems\Tables\InventoryCheckItemsTable;
use App\Models\InventoryCheckItem;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InventoryCheckItemResource extends Resource
{
    protected static ?string $model = InventoryCheckItem::class;

    protected static bool $shouldRegisterNavigation = false;
    public static function form(Schema $schema): Schema
    {
        return InventoryCheckItemForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InventoryCheckItemsTable::configure($table);
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
            'index' => ListInventoryCheckItems::route('/'),
            'create' => CreateInventoryCheckItem::route('/create'),
            'edit' => EditInventoryCheckItem::route('/{record}/edit'),
        ];
    }
}
