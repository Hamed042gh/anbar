<?php

namespace App\Filament\Resources\PurchaseOrderItems;

use App\Enums\NavigationGroup;
use App\Filament\Resources\PurchaseOrderItems\Pages\CreatePurchaseOrderItem;
use App\Filament\Resources\PurchaseOrderItems\Pages\EditPurchaseOrderItem;
use App\Filament\Resources\PurchaseOrderItems\Pages\ListPurchaseOrderItems;
use App\Filament\Resources\PurchaseOrderItems\Schemas\PurchaseOrderItemForm;
use App\Filament\Resources\PurchaseOrderItems\Tables\PurchaseOrderItemsTable;
use App\Models\PurchaseOrderItem;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PurchaseOrderItemResource extends Resource
{
    protected static ?string $model = PurchaseOrderItem::class;

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Schema $schema): Schema
    {
        return PurchaseOrderItemForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PurchaseOrderItemsTable::configure($table);
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
            'index' => ListPurchaseOrderItems::route('/'),
        ];
    }
}
