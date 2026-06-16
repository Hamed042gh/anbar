<?php

namespace App\Filament\Resources\Permissions\Schemas;

use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class PermissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            // ───── اطلاعات دسترسی ─────
            Section::make('اطلاعات دسترسی')
                ->description('نام و تنظیمات اصلی این دسترسی')
                ->icon('heroicon-o-shield-check')
                ->schema([

                    TextInput::make('name')
                        ->label('نام دسترسی')
                        ->placeholder('مثال: post.create')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->prefixIcon('heroicon-o-key')
                        ->helperText('فرمت پیشنهادی: resource.action — مثلاً post.edit'),

                    TextInput::make('guard_name')
                        ->default('web')
                        ->hidden(),

                ]),

            // ───── نقش‌های دارای این دسترسی ─────
            Section::make('نقش‌های دارای این دسترسی')
                ->description('نقش‌هایی که این دسترسی به آن‌ها اختصاص داده شده')
                ->icon('heroicon-o-user-group')
                ->collapsed()
                ->visible(fn ($record) => $record !== null)
                ->schema([

                    Placeholder::make('roles')
                        ->label('')
                        ->content(function ($record) {
                            $roles = $record?->roles;

                            if ($roles === null || $roles->isEmpty()) {
                                return new HtmlString(
                                    '<span style="color:#888;font-size:13px;">این دسترسی به هیچ نقشی اختصاص داده نشده</span>'
                                );
                            }

                            $badges = $roles->map(fn ($r) =>
                                '<span style="
                                    display:inline-block;
                                    background:#EEF2FF;
                                    color:#4338CA;
                                    border:1px solid #C7D2FE;
                                    border-radius:6px;
                                    padding:3px 10px;
                                    font-size:12px;
                                    margin:2px;
                                ">' . e($r->name) . '</span>'
                            )->implode(' ');

                            return new HtmlString($badges);
                        }),

                ]),

            // ───── کاربران دارای این دسترسی ─────
            Section::make('کاربران دارای این دسترسی')
                ->description('کاربرانی که از طریق نقش‌هایشان این دسترسی را دارند')
                ->icon('heroicon-o-users')
                ->collapsed()
                ->visible(fn ($record) => $record !== null)
                ->schema([

                    Placeholder::make('users')
                        ->label('')
                        ->content(function ($record) {
                            $users = $record?->users;

                            if ($users === null || $users->isEmpty()) {
                                return new HtmlString(
                                    '<span style="color:#888;font-size:13px;">هیچ کاربری مستقیماً این دسترسی را ندارد</span>'
                                );
                            }

                            $items = $users->map(fn ($u) =>
                                '<span style="
                                    display:inline-flex;
                                    align-items:center;
                                    gap:6px;
                                    background:#F0FDF4;
                                    color:#166534;
                                    border:1px solid #BBF7D0;
                                    border-radius:6px;
                                    padding:3px 10px;
                                    font-size:12px;
                                    margin:2px;
                                ">' . e($u->name) . '</span>'
                            )->implode(' ');

                            return new HtmlString($items);
                        }),

                ]),

        ]);
    }
}