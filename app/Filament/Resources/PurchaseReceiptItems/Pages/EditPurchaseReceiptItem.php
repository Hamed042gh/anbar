<?php

namespace App\Filament\Resources\PurchaseReceiptItems\Pages;

use App\Filament\Resources\PurchaseReceiptItems\PurchaseReceiptItemResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPurchaseReceiptItem extends EditRecord
{
    protected static string $resource = PurchaseReceiptItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
