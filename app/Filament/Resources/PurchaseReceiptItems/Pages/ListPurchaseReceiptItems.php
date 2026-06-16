<?php

namespace App\Filament\Resources\PurchaseReceiptItems\Pages;

use App\Filament\Resources\PurchaseReceiptItems\PurchaseReceiptItemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPurchaseReceiptItems extends ListRecords
{
    protected static string $resource = PurchaseReceiptItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
