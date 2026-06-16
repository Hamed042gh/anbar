<?php

namespace App\Filament\Resources\InventoryChecks\Pages;

use App\Filament\Resources\InventoryChecks\InventoryCheckResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInventoryCheck extends CreateRecord
{
    protected static string $resource = InventoryCheckResource::class;
}
