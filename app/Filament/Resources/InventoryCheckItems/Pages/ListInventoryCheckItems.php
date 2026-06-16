<?php

namespace App\Filament\Resources\InventoryCheckItems\Pages;

use App\Filament\Resources\InventoryCheckItems\InventoryCheckItemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInventoryCheckItems extends ListRecords
{
    protected static string $resource = InventoryCheckItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
