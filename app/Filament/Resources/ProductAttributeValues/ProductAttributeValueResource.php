<?php

namespace App\Filament\Resources\ProductAttributeValues;

use App\Filament\Resources\ProductAttributeValues\Pages\CreateProductAttributeValue;
use App\Filament\Resources\ProductAttributeValues\Pages\EditProductAttributeValue;
use App\Filament\Resources\ProductAttributeValues\Pages\ListProductAttributeValues;
use App\Filament\Resources\ProductAttributeValues\Schemas\ProductAttributeValueForm;
use App\Filament\Resources\ProductAttributeValues\Tables\ProductAttributeValuesTable;
use App\Models\ProductAttributeValue;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProductAttributeValueResource extends Resource
{
    protected static ?string $model = ProductAttributeValue::class;

    protected static bool $shouldRegisterNavigation = false;
    public static function form(Schema $schema): Schema
    {
        return ProductAttributeValueForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductAttributeValuesTable::configure($table);
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
            'index' => ListProductAttributeValues::route('/'),
            'create' => CreateProductAttributeValue::route('/create'),
            'edit' => EditProductAttributeValue::route('/{record}/edit'),
        ];
    }
}
