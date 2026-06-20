<?php

namespace App\Filament\Resources\Inventories;

use App\Enums\NavigationGroup;
use App\Filament\Concerns\HasCachedNavigationBadge;
use App\Filament\Resources\Inventories\Pages\CreateInventory;
use App\Filament\Resources\Inventories\Pages\EditInventory;
use App\Filament\Resources\Inventories\Pages\ListInventories;
use App\Filament\Resources\Inventories\Schemas\InventoryForm;
use App\Filament\Resources\Inventories\Tables\InventoriesTable;
use App\Models\Inventory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class InventoryResource extends Resource
{
    use HasCachedNavigationBadge;
    protected static ?string $model = Inventory::class;

    protected static string | UnitEnum | null $navigationGroup = NavigationGroup::Warehouse;
    protected static ?string $modelLabel = 'موجودی';
    protected static ?string $pluralModelLabel = 'موجودی‌ها';
    protected static ?string $navigationLabel = 'موجودی‌ها';
    protected static ?int $navigationSort = 2;
    public static function form(Schema $schema): Schema
    {
        return InventoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InventoriesTable::configure($table);
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
            'index' => ListInventories::route('/'),
        ];
    }

}
