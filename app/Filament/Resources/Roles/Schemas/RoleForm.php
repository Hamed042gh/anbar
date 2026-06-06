<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Spatie\Permission\Models\Permission;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('نام نقش')
                    ->required()
                    ->unique(ignoreRecord: true),

                TextInput::make('guard_name')
                    ->default('web')
                    ->hidden(),

                CheckboxList::make('permissions')
                    ->label('دسترسی‌ها')
                    ->relationship('permissions', 'name')
                    ->options(Permission::pluck('name', 'name'))
                    ->columns(3)
                    ->searchable(),
            ]);
    }
}
