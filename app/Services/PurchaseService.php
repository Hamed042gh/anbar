<?php

namespace App\Services;

use App\Models\PurchaseOrder;
use App\Models\PurchaseReceipt;
use App\Models\PurchaseReceiptItem;
use Illuminate\Support\Facades\DB;

class PurchaseService
{
    public function __construct(
        private readonly InventoryService $inventoryService
    ) {}

    public function receive(PurchaseOrder $order, array $items, array $meta): PurchaseReceipt
    {
        return DB::transaction(function () use ($order, $items, $meta) {
            $receipt = $order->receipts()->create([
                'number'       => $meta['number'],
                'warehouse_id' => $order->warehouse_id,
                'user_id'      => $meta['user_id'],
                'note'         => $meta['note'] ?? null,
                'received_at'  => now(),
            ]);

            foreach ($items as $item) {
                $orderItem = $order->items()->findOrFail($item['purchase_order_item_id']);

                abort_if(
                    $item['quantity'] > $orderItem->remainingQuantity(),
                    422,
                    'مقدار دریافتی بیشتر از سفارش است.'
                );

                $receipt->items()->create([
                    'purchase_order_item_id' => $orderItem->id,
                    'variant_id'             => $orderItem->variant_id,
                    'quantity'               => $item['quantity'],
                    'unit_cost'              => $orderItem->unit_cost,
                    'total_cost'             => $item['quantity'] * $orderItem->unit_cost,
                ]);

                $orderItem->increment('received_quantity', $item['quantity']);

                $this->inventoryService->move([
                    'variant_id'         => $orderItem->variant_id,
                    'warehouse_id'       => $order->warehouse_id,
                    'user_id'            => $meta['user_id'],
                    'type'               => 'purchase',
                    'quantity'           => $item['quantity'],
                    'unit_cost'          => $orderItem->unit_cost,
                    'referenceable_type' => PurchaseReceipt::class,
                    'referenceable_id'   => $receipt->id,
                ]);
            }

            $this->updateOrderStatus($order);

            return $receipt;
        });
    }

    private function updateOrderStatus(PurchaseOrder $order): void
    {
        $order->refresh();

        $allReceived = $order->items->every(fn ($item) => $item->isFullyReceived());

        $order->update([
            'status' => $allReceived ? 'received' : 'partial',
        ]);
    }
}