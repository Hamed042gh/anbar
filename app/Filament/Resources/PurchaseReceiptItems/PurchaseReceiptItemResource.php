<?php

namespace App\Filament\Resources\PurchaseReceiptItems;

use App\Filament\Resources\PurchaseReceiptItems\Pages\CreatePurchaseReceiptItem;
use App\Filament\Resources\PurchaseReceiptItems\Pages\EditPurchaseReceiptItem;
use App\Filament\Resources\PurchaseReceiptItems\Pages\ListPurchaseReceiptItems;
use App\Filament\Resources\PurchaseReceiptItems\Schemas\PurchaseReceiptItemForm;
use App\Filament\Resources\PurchaseReceiptItems\Tables\PurchaseReceiptItemsTable;
use App\Models\PurchaseReceiptItem;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PurchaseReceiptItemResource extends Resource
{
    protected static ?string $model = PurchaseReceiptItem::class;

    protected static bool $shouldRegisterNavigation = false;
    public static function form(Schema $schema): Schema
    {
        return PurchaseReceiptItemForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PurchaseReceiptItemsTable::configure($table);
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
            'index' => ListPurchaseReceiptItems::route('/'),
        ];
    }
}
