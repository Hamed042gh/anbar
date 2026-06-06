<?php

namespace App\Filament\Resources\Permissions\Schemas;

use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PermissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('نام دسترسی')
                    ->required()
                    ->unique(ignoreRecord: true)
 ,

                TextInput::make('guard_name')
                    ->default('web')
                    ->hidden(),

                Placeholder::make('roles')
                    ->label('نقش‌های دارای این دسترسی')
                    ->content(fn($record) => $record?->roles->pluck('name')->join('، ') ?: '—'),

                Placeholder::make('users')
                    ->label('کاربران دارای این دسترسی')
                    ->content(fn($record) => $record?->users->pluck('name')->join('، ') ?: '—'),
            ]);
    }
}
