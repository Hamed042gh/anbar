<?php

namespace App\Filament\Resources\Customers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

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
                       Select::make('province_id')
                        ->label('استان')
                        ->relationship('province', 'name')
                        ->live()
                        ->searchable()
                        ->preload()
                        ->required()
                        ->afterStateUpdated(fn (callable $set) => $set('city_id', null)),

                    Select::make('city_id')
                        ->label('شهر')
                        ->relationship(
                            name: 'city',
                            titleAttribute: 'name',
                            modifyQueryUsing: fn (Builder $query, callable $get) =>
                                $query->where('province_id', $get('province_id')),
                        )
                        ->searchable()
                        ->preload()
                        ->required()
                        ->disabled(fn (callable $get) => ! $get('province_id')),
                        TextInput::make('postal_code')
                            ->label('کد پستی')
                            ->required()
                            ->length(10)
                            ->rule('regex:/^[0-9]{10}$/')
                            ->validationMessages([
                                'regex' => 'کد پستی باید دقیقاً ۱۰ رقم باشد.',
                            ]),
                        Textarea::make('address')
                            ->label('آدرس کامل')
                            ->required()
                            ->rows(2)
                            ->minLength(10)
                            ->columnSpanFull(),
                    ])
                    ->columns(3),
            ]);
    }
}