<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('اطلاعات پایه')
                    ->columns(2)
                    ->components([
                        TextInput::make('name')
                            ->label('نام')
                            ->required(),

                        TextInput::make('email')
                            ->label('ایمیل')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true),

                        TextInput::make('password')
                            ->label('رمز عبور')
                            ->password()
                            // ✅ فقط خالی نبودن چک میکنه، هش توی Service
                            ->dehydrated(fn($state) => filled($state))
                            ->nullable(),

                        Toggle::make('is_super_admin')
                            ->label('سوپر ادمین')
                            ->onColor('danger')
                            ->offColor('gray'),
                    ]),

                Section::make('نقش‌ها')
                    ->components([
                        CheckboxList::make('roles')
                            ->label('')
                            ->relationship('roles', 'name')
                            ->options(fn() => Role::pluck('name', 'id'))
                            ->columns(3),
                    ]),

                Section::make('دسترسی‌های مستقیم')
                    ->components([
                        CheckboxList::make('permissions')
                            ->label('')
                            ->relationship('permissions', 'name')
                            ->options(fn() => Permission::pluck('name', 'id'))
                            ->columns(3)
                            ->searchable(),
                    ]),
            ]);
    }
}
