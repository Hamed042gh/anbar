<?php

namespace App\Filament\Resources\InventoryChecks\Pages;

use App\Filament\Resources\InventoryChecks\InventoryCheckResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInventoryChecks extends ListRecords
{
    protected static string $resource = InventoryCheckResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
