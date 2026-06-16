<?php

namespace App\Filament\Resources\Roles\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\Summarizers\Average;
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

                // 👑 نام نقش
                TextColumn::make('name')
                    ->label('نام نقش')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                   
                    ->icon('heroicon-o-user-group')
                    ->color('primary')
                    ->formatStateUsing(fn ($state) => strtoupper($state)),

                // 🔐 تعداد دسترسی‌ها
                TextColumn::make('permissions_count')
                    ->label('تعداد دسترسی‌ها')
                    ->counts('permissions')
                    ->badge()
                    ->color(fn ($state) =>
                        $state > 10 ? 'danger' : ($state > 5 ? 'warning' : 'success')
                    )
                    ->icon('heroicon-o-shield-check'),

                // 👥 تعداد کاربران
                TextColumn::make('users_count')
                    ->label('تعداد کاربران')
                    ->counts('users')
                    ->badge()
                    ->color(fn ($state) =>
                        $state > 20 ? 'danger' : ($state > 5 ? 'warning' : 'success')
                    )
                    ->icon('heroicon-o-users'),

                // 📅 تاریخ ایجاد
                TextColumn::make('created_at')
                    ->label('تاریخ ایجاد')
                    ->dateTime('Y/m/d H:i')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->icon('heroicon-o-calendar'),
            ])

            ->filters([])

            // ⚡ اکشن‌های هر ردیف
            ->recordActions([

                EditAction::make()
                    ->label('ویرایش')
                    ->icon('heroicon-m-pencil-square')
                    ->modalHeading('ویرایش نقش')
                    ->modalWidth('4xl')
                    ->modalSubmitActionLabel('ذخیره تغییرات')
                    ->successNotificationTitle('نقش با موفقیت ویرایش شد ✔️'),

                DeleteAction::make()
                    ->label('حذف')
                    ->icon('heroicon-m-trash')
                    ->requiresConfirmation()
                    ->modalHeading('حذف نقش')
                    ->modalDescription('آیا از حذف این نقش مطمئن هستید؟')
                    ->successNotificationTitle('نقش حذف شد ❌'),
            ])

            // ➕ دکمه ایجاد
            ->headerActions([
                CreateAction::make()
                    ->label('ایجاد نقش')
                    ->icon('heroicon-m-plus-circle')
                    ->modalHeading('ایجاد نقش جدید')
                    ->modalSubmitActionLabel('ثبت نقش')
                    ->modalWidth('4xl')
                    ->successNotificationTitle('نقش با موفقیت ایجاد شد ✔️'),
            ])

            // 🧹 عملیات گروهی
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('حذف انتخاب‌شده‌ها')
                        ->requiresConfirmation()
                        ->modalHeading('حذف گروهی نقش‌ها')
                        ->modalDescription('آیا از حذف موارد انتخاب‌شده مطمئن هستید؟')
                        ->successNotificationTitle('نقش‌های انتخاب‌شده حذف شدند ❌'),
                ]),
            ])

            // 🧊 حالت خالی
            ->emptyStateHeading('هیچ نقشی ثبت نشده است')
            ->emptyStateDescription('برای شروع یک نقش جدید ایجاد کنید')
            ->emptyStateIcon('heroicon-o-user-group');
    }
}