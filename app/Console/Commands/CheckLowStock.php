<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\{Inventory, User};
use App\Notifications\LowStockNotification;

class CheckLowStock extends Command
{
    protected $signature = 'stock:check-low';
    protected $description = 'Check low stock items and notify admins';

    public function handle(): void
    {
        $lowStockItems = Inventory::query()
            ->join('product_variants', 'product_variants.id', '=', 'inventories.variant_id')
            ->whereColumn('inventories.quantity', '<=', 'product_variants.reorder_level')
            ->with(['variant.product', 'warehouse'])
            ->select('inventories.*')
            ->get();

        if ($lowStockItems->isEmpty()) {
            $this->info('All stock levels are sufficient.');
            return;
        }

        $admins = User::where('is_super_admin', true)->get();

        foreach ($lowStockItems as $item) {
            foreach ($admins as $admin) {
                $admin->notify(new LowStockNotification($item));
            }
        }

        $this->info("Notifications sent for {$lowStockItems->count()} item(s).");
    }
}
