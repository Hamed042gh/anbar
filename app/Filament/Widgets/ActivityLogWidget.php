<?php

namespace App\Filament\Widgets;

use Filament\Widgets\TableWidget;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Spatie\Activitylog\Models\Activity;

class ActivityLogWidget extends TableWidget
{
    protected static ?string $heading = '📋 لاگ فعالیت‌ها';
    protected int|string|array $columnSpan = 'full';
    protected static ?int $sort = 5;

    public function table(Table $table): Table
    {
        return $table
            ->query(Activity::query()->latest()->limit(20))
            ->paginated(false)
            ->striped()
            ->columns([
                TextColumn::make('causer.name')
                    ->label('کاربر')
                    ->badge()
                    ->color('primary')
                    ->default('سیستم')
                    ->icon('heroicon-m-user'),

                TextColumn::make('subject_type')
                    ->label('بخش')
                    ->formatStateUsing(fn($state) => match(class_basename($state)) {
                        'Inventory'     => '📦 موجودی',
                        'Invoice'       => '🧾 فاکتور',
                        'PurchaseOrder' => '🚚 سفارش خرید',
                        'Product'       => '🏷️ کالا',
                        default         => class_basename($state ?? ''),
                    })
                    ->badge()
                    ->color('gray'),

                TextColumn::make('description')
                    ->label('عملیات')
                    ->badge()
                    ->color(fn($state) => match($state) {
                        'ایجاد شد'  => 'success',
                        'ویرایش شد' => 'warning',
                        'حذف شد'   => 'danger',
                        default     => 'gray',
                    }),

                TextColumn::make('properties')
                    ->label('فیلدهای تغییر یافته')
                    ->formatStateUsing(function ($state) {
                        $props = is_string($state)
                            ? json_decode($state, true)
                            : (is_object($state) ? $state->toArray() : $state);

                        $old = $props['old'] ?? [];
                        $new = $props['attributes'] ?? [];

                        if (empty($old) && empty($new)) return '—';

                        $changed = collect($new)
                            ->keys()
                            ->filter(fn($k) => isset($old[$k]) && $old[$k] !== $new[$k])
                            ->join('، ');

                        return $changed ?: '—';
                    })
                    ->color('gray')
                    ->wrap(),

                TextColumn::make('created_at')
                    ->label('زمان')
                    ->since()
                    ->color('gray')
                    ->sortable(),
            ]);
    }
}
