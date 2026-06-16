<?php

namespace App\Filament\Resources\InventoryChecks\Pages;

use App\Filament\Resources\InventoryChecks\InventoryCheckResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInventoryCheck extends EditRecord
{
    protected static string $resource = InventoryCheckResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
