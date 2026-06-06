<?php

namespace App\Filament\Resources\Permissions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PermissionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->striped()
            ->defaultSort('name')
            ->columns([
                TextColumn::make('name')
                    ->label('نام دسترسی')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('کپی شد ✅')
                    ->fontFamily('mono')
                    ->weight('bold'),

                TextColumn::make('roles_count')
                    ->label('نقش‌ها')
                    ->counts('roles')
                    ->badge()
                    ->color('warning'),

                TextColumn::make('users_count')
                    ->label('کاربران')
                    ->counts('users')
                    ->badge()
                    ->color('success'),

                TextColumn::make('created_at')
                    ->label('تاریخ ایجاد')
                    ->dateTime('Y/m/d H:i')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->slideOver()
                    ->modalWidth('xl')
                    ->stickyModalHeader()
                    ->stickyModalFooter()
                    ->modalHeading('ویرایش دسترسی')
                    ->modalSubmitActionLabel('ذخیره تغییرات')
                    ->successNotificationTitle('دسترسی با موفقیت ویرایش شد ✅'),

                DeleteAction::make()
                    ->requiresConfirmation()
                    ->successNotificationTitle('دسترسی حذف شد'),
            ])
            ->toolbarActions([
                CreateAction::make()
                    ->label('دسترسی جدید')
                    ->icon('heroicon-m-plus-circle')
                    ->slideOver()
                    ->modalWidth('xl')
                    ->stickyModalHeader()
                    ->stickyModalFooter()
                    ->modalHeading('ایجاد دسترسی جدید')
                    ->modalSubmitActionLabel('ایجاد دسترسی')
                    ->successNotificationTitle('دسترسی با موفقیت ایجاد شد ✅'),

                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('حذف گروهی')
                        ->requiresConfirmation(),
                ]),
            ])
            ->emptyStateHeading('دسترسی‌ای پیدا نشد')
            ->emptyStateDescription('هنوز هیچ دسترسی‌ای تعریف نشده است')
            ->emptyStateIcon('heroicon-o-shield-check');
    }
}
