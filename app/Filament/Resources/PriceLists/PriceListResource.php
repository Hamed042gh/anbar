<?php

namespace App\Filament\Resources\PriceLists;

use App\Enums\NavigationGroup;
use App\Filament\Resources\PriceLists\RelationManagers\ItemsRelationManager;
use App\Filament\Resources\PriceLists\Pages\CreatePriceList;
use App\Filament\Resources\PriceLists\Pages\EditPriceList;
use App\Filament\Resources\PriceLists\Pages\ListPriceLists;
use App\Filament\Resources\PriceLists\Schemas\PriceListForm;
use App\Filament\Resources\PriceLists\Tables\PriceListsTable;
use App\Models\PriceList;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PriceListResource extends Resource
{
    protected static ?string $model = PriceList::class;

    protected static string | UnitEnum | null $navigationGroup = NavigationGroup::Sales;
    protected static ?string $modelLabel = 'لیست قیمت';
    protected static ?string $pluralModelLabel = 'لیست‌های قیمت';
    protected static ?string $navigationLabel = 'لیست‌های قیمت';
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return PriceListForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PriceListsTable::configure($table);
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
            'index' => ListPriceLists::route('/'),
            'create' => CreatePriceList::route('/create'),
            'edit' => EditPriceList::route('/{record}/edit'),
        ];
    }
}
