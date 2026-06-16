<?php

namespace App\Filament\Resources\Permissions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PermissionsTable
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

    private static array $groupLabels = [
        'comment'    => '💬 کامنت‌ها',
        'permission' => '🔐 دسترسی‌ها',
        'post'       => '📝 پست‌ها',
        'role'       => '👑 نقش‌ها',
        'user'       => '👤 کاربران',
    ];

    public static function configure(Table $table): Table
    {
        return $table
            ->striped()
            ->defaultSort('name')
            ->columns([

                // 🔑 نام دسترسی
                TextColumn::make('name')
                    ->label('نام دسترسی')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('کپی شد ✔️')
                    ->weight('bold')
                    ->icon('heroicon-o-key')
                    ->color('primary')
                    ->formatStateUsing(fn ($state) =>
                        self::$permissionLabels[$state] ?? $state
                    ),

                // 🏷 تعداد نقش‌ها
                TextColumn::make('roles_count')
                    ->label('تعداد نقش‌ها')
                    ->counts('roles')
                    ->badge()
                    ->color(fn ($state) =>
                        $state > 5 ? 'danger' : ($state > 2 ? 'warning' : 'success')
                    )
                    ->icon('heroicon-o-user-group'),

                // 👤 تعداد کاربران
                TextColumn::make('users_count')
                    ->label('تعداد کاربران')
                    ->counts('users')
                    ->badge()
                    ->color(fn ($state) =>
                        $state > 10 ? 'danger' : ($state > 3 ? 'warning' : 'success')
                    )
                    ->icon('heroicon-o-users'),

                // 📅 تاریخ ایجاد
                TextColumn::make('created_at')
                    ->label('تاریخ ایجاد')
                    ->dateTime('Y/m/d')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->icon('heroicon-o-calendar'),
            ])

            ->filters([

                SelectFilter::make('group')
                    ->label('دسته‌بندی')
                    ->placeholder('همه دسترسی‌ها')
                    ->options(self::$groupLabels)
                    ->query(fn ($query, $data) =>
                        blank($data['value'])
                            ? $query
                            : $query->where('name', 'like', $data['value'] . '.%')
                    ),

            ])

            ->filtersLayout(\Filament\Tables\Enums\FiltersLayout::AboveContent)

            // ⚡ اکشن‌های هر ردیف
            ->recordActions([

                EditAction::make()
                    ->label('ویرایش')
                    ->icon('heroicon-m-pencil-square')
                    ->modalHeading('ویرایش دسترسی')
                    ->modalWidth('5xl')
                    ->modalSubmitActionLabel('ذخیره تغییرات')
                    ->successNotificationTitle('دسترسی با موفقیت ویرایش شد ✔️')
                    ->color('warning'),

                DeleteAction::make()
                    ->label('حذف')
                    ->icon('heroicon-m-trash')
                    ->requiresConfirmation()
                    ->modalHeading('حذف دسترسی')
                    ->modalDescription('آیا از حذف این دسترسی مطمئن هستید؟')
                    ->successNotificationTitle('دسترسی حذف شد ❌')
                    ->color('danger'),
            ])

            // ➕ دکمه ایجاد
            ->headerActions([
                CreateAction::make()
                    ->label('ایجاد دسترسی')
                    ->icon('heroicon-m-plus-circle')
                    ->color('primary')
                    ->modalHeading('ایجاد دسترسی جدید')
                    ->modalSubmitActionLabel('ثبت دسترسی')
                    ->modalWidth('5xl')
                    ->successNotificationTitle('دسترسی با موفقیت ایجاد شد ✔️'),
            ])

            // 🧹 عملیات گروهی
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('حذف انتخاب‌شده‌ها')
                        ->requiresConfirmation()
                        ->modalHeading('حذف گروهی')
                        ->modalDescription('آیا از حذف آیتم‌های انتخاب‌شده مطمئن هستید؟')
                        ->successNotificationTitle('دسترسی‌های انتخاب‌شده حذف شدند ❌')
                        ->color('danger'),
                ]),
            ])

            // 🧊 حالت خالی جدول
            ->emptyStateHeading('هیچ دسترسی‌ای ثبت نشده است')
            ->emptyStateDescription('برای شروع، یک دسترسی جدید ایجاد کنید')
            ->emptyStateIcon('heroicon-o-shield-check');
    }
}