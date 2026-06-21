<?php

namespace App\Notifications;

use App\Models\Inventory;
use Filament\Actions\Action;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Notifications\Notification;

class LowStockNotification extends Notification
{
    public function __construct(public Inventory $inventory) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $product = $this->inventory->variant?->product?->name ?? 'کالای ناشناس';
        $qty = $this->inventory->quantity;
        $reorderLevel = $this->inventory->variant?->reorder_level ?? 0;
        $warehouse = $this->inventory->warehouse?->name ?? 'بدون انبار';

        [$level, $title, $emoji, $color, $icon] = $this->severity($qty, $reorderLevel);

        return FilamentNotification::make()
            ->title("{$title} {$emoji}")
            ->body(
                "{$product}\n"
                . "انبار: {$warehouse}\n"
                . "موجودی فعلی: {$qty} عدد (حد سفارش مجدد: {$reorderLevel})"
            )
            ->color($color)
            ->icon($icon)
            ->iconColor($color)
            ->when($level === 'critical', fn ($n) => $n->persistent())
            ->actions([
                Action::make('view')
                    ->label('مشاهده موجودی')
                    ->url('/admin/inventories')
                    ->button(),
                Action::make('order')
                    ->label('ثبت سفارش خرید')
                    ->url('/admin/purchase-orders/create')
                    ->color('primary'),
            ])
            ->getDatabaseMessage();
    }

    private function severity(int $qty, int $reorderLevel): array
    {
        return match (true) {
            $qty <= 0 => ['critical', 'موجودی صفر شد', '🔴', 'danger', 'heroicon-o-x-circle'],
            $qty <= $reorderLevel / 2 => ['urgent', 'هشدار جدی موجودی', '🟠', 'warning', 'heroicon-o-fire'],
            default => ['low', 'هشدار موجودی کم', '🟡', 'warning', 'heroicon-o-exclamation-triangle'],
        };
    }
}
