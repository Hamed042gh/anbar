<?php

namespace App\Filament\Resources\ProductAttributes;

use App\Enums\NavigationGroup;
use App\Filament\Resources\ProductAttributes\Pages\CreateProductAttribute;
use App\Filament\Resources\ProductAttributes\Pages\EditProductAttribute;
use App\Filament\Resources\ProductAttributes\Pages\ListProductAttributes;
use App\Filament\Resources\ProductAttributes\Schemas\ProductAttributeForm;
use App\Filament\Resources\ProductAttributes\Tables\ProductAttributesTable;
use App\Filament\Resources\ProductAttributes\RelationManagers\ValuesRelationManager;
use App\Models\ProductAttribute;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ProductAttributeResource extends Resource
{
    protected static ?string $model = ProductAttribute::class;

    protected static string | UnitEnum | null $navigationGroup = NavigationGroup::Products;
    protected static ?string $modelLabel = 'مشخصه کالا';
    protected static ?string $pluralModelLabel = 'مشخصات کالا';
    protected static ?string $navigationLabel = 'مشخصات کالا';
    protected static ?int $navigationSort = 3;
    public static function form(Schema $schema): Schema
    {
        return ProductAttributeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductAttributesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ValuesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProductAttributes::route('/'),
        ];
    }
}
