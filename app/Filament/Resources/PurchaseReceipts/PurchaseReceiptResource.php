<?php

namespace App\Filament\Resources\PurchaseReceipts;

use App\Enums\NavigationGroup;
use App\Filament\Resources\PurchaseReceipts\RelationManagers\ItemsRelationManager;
use App\Filament\Resources\PurchaseReceipts\Pages\CreatePurchaseReceipt;
use App\Filament\Resources\PurchaseReceipts\Pages\EditPurchaseReceipt;
use App\Filament\Resources\PurchaseReceipts\Pages\ListPurchaseReceipts;
use App\Filament\Resources\PurchaseReceipts\Schemas\PurchaseReceiptForm;
use App\Filament\Resources\PurchaseReceipts\Tables\PurchaseReceiptsTable;
use App\Models\PurchaseReceipt;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PurchaseReceiptResource extends Resource
{
    protected static ?string $model = PurchaseReceipt::class;

    protected static string | UnitEnum | null $navigationGroup = NavigationGroup::Purchase;
    protected static ?string $modelLabel = 'رسید خرید';
    protected static ?string $pluralModelLabel = 'رسیدهای خرید';
    protected static ?string $navigationLabel = 'رسیدهای خرید';
    protected static ?int $navigationSort = 3;
    public static function form(Schema $schema): Schema
    {
        return PurchaseReceiptForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PurchaseReceiptsTable::configure($table);
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
            'index' => ListPurchaseReceipts::route('/'),
        ];
    }
}
