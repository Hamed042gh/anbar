<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Spatie\Permission\Models\Permission;

class RoleForm
{
    private static array $permissionLabels = [
        'comment.create'    => 'ایجاد کامنت',
        'comment.delete'    => 'حذف کامنت',
        'comment.edit'      => 'ویرایش کامنت',
        'comment.view'      => 'مشاهده کامنت',
        'permission.create' => 'ایجاد دسترسی',
        'permission.delete' => 'حذف دسترسی',
        'permission.edit'   => 'ویرایش دسترسی',
        'permission.view'   => 'مشاهده دسترسی',
        'post.create'       => 'ایجاد پست',
        'post.delete'       => 'حذف پست',
        'post.edit'         => 'ویرایش پست',
        'post.view'         => 'مشاهده پست',
        'role.create'       => 'ایجاد نقش',
        'role.delete'       => 'حذف نقش',
        'role.edit'         => 'ویرایش نقش',
        'role.view'         => 'مشاهده نقش',
        'user.create'       => 'ایجاد کاربر',
        'user.delete'       => 'حذف کاربر',
        'user.edit'         => 'ویرایش کاربر',
        'user.view'         => 'مشاهده کاربر',
    ];

    private static function toFarsi(string $name): string
    {
        return self::$permissionLabels[$name] ?? $name;
    }

    public static function configure(Schema $schema): Schema
    {
        $options = Permission::orderBy('name')
            ->pluck('name', 'name')
            ->mapWithKeys(fn ($name) => [$name => self::toFarsi($name)])
            ->toArray();

        return $schema
            ->components([

                Wizard::make([

                    Step::make('اطلاعات نقش')
                        ->icon('heroicon-o-user-group')
                        ->schema([

                            TextInput::make('name')
                                ->label('نام نقش')
                                ->placeholder('مثال: ویراستار ارشد')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->prefixIcon('heroicon-o-tag')
                                ->helperText('نام نقش باید یکتا باشد'),

                            TextInput::make('guard_name')
                                ->default('web')
                                ->hidden(),

                        ]),

                            Step::make('دسترسی‌ها')
                                ->label('دسترسی‌ها (' . Permission::count() . ')')
                                ->icon('heroicon-o-shield-check')
                                ->schema([

                            CheckboxList::make('permissions')
                                ->label('')
                                ->relationship('permissions', 'name')
                                ->options($options)
                                ->columns(4)
                                ->gridDirection('row')
                                ->searchable()
                                ->searchPrompt('جستجو...')
                                ->noSearchResultsMessage('موردی یافت نشد')
                                ->selectAllAction(fn ($a) => $a->label('انتخاب همه'))
                                ->deselectAllAction(fn ($a) => $a->label('حذف انتخاب‌ها')),

                        ]),

                ])
                ->skippable()
                ->persistStepInQueryString(),

            ]);
    }
}