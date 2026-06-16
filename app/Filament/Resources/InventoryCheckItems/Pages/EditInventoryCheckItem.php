<?php

namespace App\Filament\Resources\InventoryCheckItems\Pages;

use App\Filament\Resources\InventoryCheckItems\InventoryCheckItemResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInventoryCheckItem extends EditRecord
{
    protected static string $resource = InventoryCheckItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
