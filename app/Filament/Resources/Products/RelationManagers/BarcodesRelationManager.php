<?php

namespace App\Filament\Resources\Products\RelationManagers;

use App\Models\ProductVariant;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BarcodesRelationManager extends RelationManager
{
    protected static string $relationship = 'barcodes';
    protected static ?string $title = 'بارکدها';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('variant_id')
                    ->label('variant')
                    ->options(fn() => ProductVariant::where('product_id', $this->getOwnerRecord()->id)
                        ->pluck('sku', 'id'))
                    ->required()
                    ->native(false),

                TextInput::make('barcode')
                    ->label('بارکد')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('barcode')
            ->columns([
                TextColumn::make('variant.sku')
                    ->label('variant')
                    ->badge()
                    ->color('info'),

                TextColumn::make('barcode')
                    ->label('بارکد')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('کپی شد'),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}