<?php

namespace App\Filament\Resources\Customers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('اطلاعات اصلی')
                    ->schema([
                        TextInput::make('name')
                            ->label('نام')
                            ->required()
                            ->maxLength(255),
                        Select::make('type')
                            ->label('نوع مشتری')
                            ->options([
                                'retail' => 'خرده‌فروش',
                                'wholesale' => 'عمده‌فروش',
                            ])
                            ->default('retail')
                            ->required(),
                        TextInput::make('phone')
                            ->label('تلفن')
                            ->tel()
                            ->maxLength(20),
                        TextInput::make('email')
                            ->label('ایمیل')
                            ->email()
                            ->maxLength(255),
                        Toggle::make('is_active')
                            ->label('فعال')
                            ->default(true)
                            ->inline(false),
                    ])
                    ->columns(2),
                Section::make('اطلاعات مالی')
                    ->schema([
                        TextInput::make('credit_limit')
                            ->label('سقف اعتبار')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->minValue(0),
                        TextInput::make('balance')
                            ->label('مانده حساب')
                            ->required()
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(2),
                Section::make('آدرس')
                    ->schema([
                        Textarea::make('address')
                            ->label('آدرس')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}