<?php

namespace App\Filament\Resources\InventoryChecks\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class InventoryCheckForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('warehouse_id')
                    ->relationship('warehouse', 'name')
                    ->required(),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('status')
                    ->options([
                        'draft' => 'پیش‌نویس',
                        'in_progress' => 'در حال انجام',
                        'completed' => 'تکمیل شده',
                    ])
                    ->default('draft')
                    ->required(),
                Textarea::make('note')
                    ->columnSpanFull(),
                DateTimePicker::make('checked_at')
                    ->jalali(),
            ]);
    }
}