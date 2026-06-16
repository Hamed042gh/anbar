<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
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
                ImageColumn::make('avatar')
                    ->label('')
                    ->circular()
                    ->imageSize(40)
                    ->checkFileExistence(false)
                    ->defaultImageUrl(fn ($record) =>
                        'https://ui-avatars.com/api/?name=' . urlencode($record->name) . '&background=6366f1&color=fff'
                    ),

                TextColumn::make('name')
                    ->label('کاربر')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn ($record) => $record->email),

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
                    ->separator(',')
                    ->color(fn (string $state): string => match (true) {
                        str_contains(strtolower($state), 'admin') => 'danger',
                        str_contains(strtolower($state), 'seller') => 'success',
                        default => 'info',
                    }),

                TextColumn::make('permissions_count')
                    ->label('دسترسی‌های مستقیم')
                    ->counts('permissions')
                    ->badge()
                    ->color('gray'),

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

                SelectFilter::make('roles')
                    ->label('نقش')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload(),
            ])
            ->recordActions([
            EditAction::make()
                ->label('ویرایش')
                ->icon('heroicon-m-pencil-square')
                ->modalHeading('ویرایش کاربر')
                ->modalDescription('اطلاعات کاربر را ویرایش کنید')
                ->modalWidth('7xl')
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
                ->modalHeading('ایجاد کاربر جدید')
                ->stickyModalHeader()
                ->modalWidth('7xl')
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