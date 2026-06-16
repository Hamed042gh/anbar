<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Wizard::make([

                    Step::make('پروفایل')
                        ->icon('heroicon-o-identification')
                        ->description('تصویر و نام نمایشی کاربر')
                        ->schema([
                            FileUpload::make('avatar')
                                ->label('تصویر پروفایل')
                                ->image()
                                ->downloadable()
                                ->uploadingMessage('Uploading attachment...')
 
                                ->avatar()
                                   ->disk('public')
                                   ->visibility('public')
                                ->directory('avatars')
                                ->columnSpanFull(),

                            TextInput::make('name')
                                ->label('نام')
                                ->required()
                                ->maxLength(255)
                                ->columnSpanFull(),
                        ]),

                    Step::make('ورود و امنیت')
                        ->icon('heroicon-o-lock-closed')
                        ->description('ایمیل، رمز عبور و سطح دسترسی')
                        ->columns(2)
                        ->schema([
                            TextInput::make('email')
                                ->label('ایمیل')
                                ->email()
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->maxLength(255)
                                ->columnSpanFull(),

                            TextInput::make('password')
                                ->label('رمز عبور')
                                ->password()
                                ->revealable()
                                ->confirmed()
                                ->minLength(8)
                                ->dehydrated(fn ($state) => filled($state))
                                ->nullable()
                                ->helperText('برای عدم تغییر رمز، این فیلد را خالی بگذارید'),

                            TextInput::make('password_confirmation')
                                ->label('تکرار رمز عبور')
                                ->password()
                                ->revealable()
                                ->dehydrated(false)
                                ->nullable(),

                            Toggle::make('is_super_admin')
                                ->label('سوپر ادمین')
                                ->helperText('دسترسی کامل به تمام بخش‌های پنل')
                                ->onColor('danger')
                                ->offColor('gray')
                                ->columnSpanFull(),
                        ]),

                    Step::make('نقش‌ها')
                        ->icon('heroicon-o-user-group')
                        ->description('نقش‌های تعیین‌شده برای این کاربر')
                        ->schema([
                            CheckboxList::make('roles')
                                ->label('')
                                ->relationship('roles', 'name')
                                ->options(fn () => Role::pluck('name', 'id'))
                                ->bulkToggleable()
                                ->columns(3)
                                ->gridDirection('row'),
                        ]),

                    Step::make('دسترسی‌های مستقیم')
                        ->icon('heroicon-o-key')
                        ->description('دسترسی‌های اضافه‌ای که مستقیماً به این کاربر (فارغ از نقش) اختصاص داده می‌شود')
                        ->schema([
                            CheckboxList::make('permissions')
                                ->label('')
                                ->relationship('permissions', 'name')
                                ->options(fn () => Permission::pluck('name', 'id'))
                                ->bulkToggleable()
                                ->columns(3)
                                ->gridDirection('row')
                                ->searchable(),
                        ]),

                ])
                ->skippable()
                 ->columnSpanFull()
                ->persistStepInQueryString(),

            ]);
    }
}