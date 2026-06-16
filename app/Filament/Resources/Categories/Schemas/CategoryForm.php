<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('اطلاعات اصلی')
                    ->schema([
                        Select::make('parent_id')
                            ->label('دسته والد')
                            ->relationship('parent', 'name')
                            ->searchable()
                            ->preload()
                            ->placeholder('بدون والد')
                            ->nullable(),
                        TextInput::make('name')
                            ->label('نام')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($set, $state) =>
                                $set('slug', Str::slug($state))
                            ),
                        TextInput::make('slug')
                            ->label('اسلاگ')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Toggle::make('is_active')
                            ->label('فعال')
                            ->default(true)
                            ->inline(false),
                    ])
                    ->columns(2),
                Section::make('تصویر')
                    ->schema([
                        FileUpload::make('image')
                            ->label('تصویر دسته‌بندی')
                            ->image()
                            ->directory('categories')
                            ->nullable(),
                    ]),
            ]);
    }
}