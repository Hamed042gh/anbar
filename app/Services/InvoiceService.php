<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Facades\DB;

class InvoiceService
{
    public function __construct(
        private readonly InventoryService $inventoryService
    ) {}

    public function confirm(Invoice $invoice): void
    {
        abort_if(! $invoice->isDraft(), 422, 'فقط پیش‌نویس قابل تایید است.');

        DB::transaction(function () use ($invoice) {
            $invoice->items->each(function (InvoiceItem $item) use ($invoice) {
                $this->inventoryService->move([
                    'variant_id'   => $item->variant_id,
                    'warehouse_id' => $invoice->warehouse_id,
                    'user_id'      => $invoice->user_id,
                    'type'         => 'sale',
                    'quantity'     => -$item->quantity, // خروج از انبار
                    'unit_cost'    => $item->unit_price,
                    'referenceable_type' => Invoice::class,
                    'referenceable_id'   => $invoice->id,
                ]);
            });

            $invoice->update(['status' => 'confirmed']);
        });
    }
}