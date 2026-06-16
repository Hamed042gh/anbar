<?php

namespace App\Filament\Pages;

use Filament\Auth\Pages\EditProfile as BaseEditProfile;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;

class EditProfile extends BaseEditProfile
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                Wizard::make([

                    Step::make('پروفایل')
                        ->icon('heroicon-o-identification')
                        ->description('تصویر و نام نمایشی شما')
                        ->schema([
                            FileUpload::make('avatar')
                                ->label('تصویر پروفایل')
                                ->image()
                                ->avatar()
                                ->directory('avatars')
                                ->columnSpanFull(),

                            $this->getNameFormComponent()
                                ->columnSpanFull(),
                        ]),

                    Step::make('ورود و امنیت')
                        ->icon('heroicon-o-lock-closed')
                        ->description('ایمیل و رمز عبور شما')
                        ->schema([
                            $this->getEmailFormComponent()
                                ->columnSpanFull(),

                            $this->getPasswordFormComponent()
                                ->revealable()
                                ->helperText('برای عدم تغییر رمز، این فیلد را خالی بگذارید'),

                            $this->getPasswordConfirmationFormComponent()
                                ->revealable(),
                        ]),

                    Step::make('نقش‌های من')
                        ->icon('heroicon-o-user-group')
                        ->description('نقش‌های تعیین‌شده برای حساب شما')
                        ->schema([
                            CheckboxList::make('roles')
                                ->label('')
                                ->relationship('roles', 'name')
                                ->disabled()
                                ->columns(3)
                                ->gridDirection('row'),
                        ]),

                ])
                ->columnSpanFull()
                ->skippable()
                ->persistStepInQueryString(),

            ]);
    }
}