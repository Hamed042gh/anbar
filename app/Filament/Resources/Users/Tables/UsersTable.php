<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->striped()
            ->defaultSort('id', 'desc')
            ->paginated([10, 25, 50, 100])
            ->columns([
                TextColumn::make('name')
                    ->label('نام کاربر')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->icon('heroicon-m-user-circle')
                    ->color('primary'),

                TextColumn::make('email')
                    ->label('ایمیل')
                    ->icon('heroicon-m-envelope')
                    ->copyable()
                    ->copyMessage('ایمیل کپی شد ✅')
                    ->searchable()
                    ->color('gray'),

                IconColumn::make('is_super_admin')
                    ->label('سوپر ادمین')
                    ->boolean()
                    ->trueIcon('heroicon-o-shield-check')
                    ->falseIcon('heroicon-o-shield-exclamation')
                    ->trueColor('danger')
                    ->falseColor('gray'),

                TextColumn::make('roles.name')
                    ->label('نقش‌ها')
                    ->badge()
                    ->color('warning')
                    ->separator(','),

                TextColumn::make('permissions_count')
                    ->label('دسترسی‌های مستقیم')
                    ->counts('permissions')
                    ->badge()
                    ->color('info'),

                TextColumn::make('created_at')
                    ->label('تاریخ عضویت')
                    ->dateTime('Y/m/d H:i')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_super_admin')
                    ->label('سوپر ادمین'),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('ویرایش')
                    ->icon('heroicon-m-pencil-square')
                    ->slideOver()
                    ->modalHeading('ویرایش کاربر')
                    ->modalDescription('اطلاعات کاربر را ویرایش کنید')
                    ->modalWidth('3xl')
                    ->stickyModalHeader()
                    ->stickyModalFooter()
                    ->modalSubmitActionLabel('ذخیره تغییرات')
                    ->successNotificationTitle('کاربر با موفقیت ویرایش شد ✅'),

                DeleteAction::make()
                    ->requiresConfirmation()
                    ->successNotificationTitle('کاربر حذف شد'),
            ])
            ->toolbarActions([
                CreateAction::make()
                    ->label('کاربر جدید')
                    ->icon('heroicon-m-user-plus')
                    ->slideOver()
                    ->modalHeading('ایجاد کاربر جدید')
                    ->modalWidth('3xl')
                    ->stickyModalHeader()
                    ->stickyModalFooter()
                    ->modalSubmitActionLabel('ایجاد کاربر')
                    ->successNotificationTitle('کاربر با موفقیت ایجاد شد ✅'),

                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('حذف گروهی')
                        ->icon('heroicon-m-trash')
                        ->requiresConfirmation(),
                ]),
            ])
            ->emptyStateHeading('کاربری پیدا نشد')
            ->emptyStateDescription('هنوز هیچ کاربری ثبت نشده است')
            ->emptyStateIcon('heroicon-o-user-group');
    }
}
