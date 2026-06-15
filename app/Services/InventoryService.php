<?php

namespace App\Services;

use App\Models\Inventory;
use App\Models\StockMovement;

class InventoryService
{
    public function move(array $data): StockMovement
    {
        $movement = StockMovement::create($data);

        $this->syncInventory($movement);

        return $movement;
    }

    private function syncInventory(StockMovement $movement): void
    {
        $inventory = Inventory::firstOrCreate(
            [
                'variant_id'  => $movement->variant_id,
                'warehouse_id' => $movement->warehouse_id,
                'location_id'  => $movement->location_id,
            ],
            ['quantity' => 0, 'avg_cost' => 0]
        );

        $newQuantity = $inventory->quantity + $movement->quantity;

        // میانگین موزون فقط موقع ورود کالا
        if ($movement->quantity > 0 && $movement->unit_cost > 0) {
            $totalCost = ($inventory->quantity * $inventory->avg_cost)
                       + ($movement->quantity * $movement->unit_cost);

            $inventory->avg_cost = $newQuantity > 0
                ? $totalCost / $newQuantity
                : $movement->unit_cost;
        }

        $inventory->quantity = $newQuantity;
        $inventory->save();
    }
}
