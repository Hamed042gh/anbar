<?php

namespace App\Notifications;

use App\Models\Product;
use Filament\Actions\Action;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Notifications\Notification;

class ProductCreatedNotification extends Notification
{
    public function __construct(public Product $product) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return FilamentNotification::make()
            ->title('محصول جدید ثبت شد 🆕')
            ->body("{$this->product->name} اضافه شد")
            ->success()
            ->icon('heroicon-o-cube')
            ->actions([
                Action::make('view')
                    ->label('مشاهده محصول')
                    ->url('/admin/products')
                    ->button(),
            ])
            ->getDatabaseMessage();
    }
}
