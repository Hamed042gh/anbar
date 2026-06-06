<?php

namespace App\Filament\Resources\Roles\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RolesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->striped()
            ->defaultSort('id', 'desc')
            ->columns([
                TextColumn::make('name')
                    ->label('نام نقش')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->icon('heroicon-m-user-group')
                    ->color('primary'),

                TextColumn::make('permissions_count')
                    ->label('دسترسی‌ها')
                    ->counts('permissions')
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
                    ->modalWidth('4xl')
                    ->stickyModalHeader()
                    ->stickyModalFooter()
                    ->modalHeading('ویرایش نقش')
                    ->modalSubmitActionLabel('ذخیره تغییرات')
                    ->successNotificationTitle('نقش با موفقیت ویرایش شد ✅'),

                DeleteAction::make()
                    ->requiresConfirmation()
                    ->successNotificationTitle('نقش حذف شد'),
            ])
            ->toolbarActions([
                CreateAction::make()
                    ->label('نقش جدید')
                    ->icon('heroicon-m-plus-circle')
                    ->slideOver()
                    ->modalWidth('4xl')
                    ->stickyModalHeader()
                    ->stickyModalFooter()
                    ->modalHeading('ایجاد نقش جدید')
                    ->modalSubmitActionLabel('ایجاد نقش')
                    ->successNotificationTitle('نقش با موفقیت ایجاد شد ✅'),

                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('حذف گروهی')
                        ->requiresConfirmation(),
                ]),
            ])
            ->emptyStateHeading('نقشی پیدا نشد')
            ->emptyStateDescription('هنوز هیچ نقشی تعریف نشده است')
            ->emptyStateIcon('heroicon-o-user-group');
    }
}
