<?php

namespace App\Filament\Resources\PurchaseReceipts\Pages;

use App\Filament\Resources\PurchaseReceipts\PurchaseReceiptResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPurchaseReceipt extends EditRecord
{
    protected static string $resource = PurchaseReceiptResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
