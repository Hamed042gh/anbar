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
        $warehouse = $this->inventory->warehouse?->name ?? '';

        return FilamentNotification::make()
            ->title('کالای رو به اتمام ⚠️')
            ->body("{$product} در {$warehouse} — موجودی: {$qty} عدد")
            ->warning()
            ->icon('heroicon-o-exclamation-triangle')
            ->actions([
                Action::make('view')
                    ->label('مشاهده موجودی')
                    ->url('/admin/inventories')
                    ->button(),
            ])
            ->getDatabaseMessage();
    }
}