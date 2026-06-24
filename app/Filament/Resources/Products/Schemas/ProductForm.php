<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('اطلاعات محصول')
                    ->icon('heroicon-o-cube')
                    ->columns(2)
                    ->columnSpan(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('نام محصول')
                            ->required()
                            ->columnSpanFull(),

                        TextInput::make('sku')
                            ->label('SKU')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->prefix('#'),

                        Select::make('type')
                            ->label('نوع')
                            ->options([
                                'simple'       => 'ساده',
                                'variable'     => 'متغیر',
                                'manufactured' => 'تولیدی',
                            ])
                            ->default('simple')
                            ->required()
                            ->native(false),

                        Select::make('category_id')
                            ->label('دسته‌بندی')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->native(false),

                        Select::make('unit_id')
                            ->label('واحد اندازه‌گیری')
                            ->relationship('unit', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->native(false),

                        Textarea::make('description')
                            ->label('توضیحات')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),

                Section::make()
                    ->columnSpan(1)
                    ->schema([
                        Section::make('وضعیت')
                            ->icon('heroicon-o-check-circle')
                            ->schema([
                                Toggle::make('is_active')
                                    ->label('محصول فعال است')
                                    ->default(true)
                                    ->onColor('success')
                                    ->offColor('danger')
                                    ->inline(false),
                            ]),

                        Section::make('تصاویر')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('gallery')
                                    ->label('')
                                    ->collection('gallery')
                                    ->multiple()
                                    ->reorderable()
                                    ->image()
                                    ->imageEditor()
                                    ->maxFiles(10)
                                    ->panelLayout('grid')
                                    ->columnSpanFull(),
                            ]),
                    ]),
            ]);
    }
}