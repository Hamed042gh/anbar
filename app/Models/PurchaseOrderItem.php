<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseOrderItem extends Model
{
    protected $fillable = [
        'purchase_order_id', 'variant_id',
        'quantity', 'received_quantity', 'unit_cost', 'total_cost',
    ];

    protected $casts = [
        'quantity'          => 'decimal:3',
        'received_quantity' => 'decimal:3',
        'unit_cost'         => 'decimal:2',
        'total_cost'        => 'decimal:2',
    ];

    public function purchaseOrder(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function receiptItems(): HasMany
    {
        return $this->hasMany(PurchaseReceiptItem::class);
    }

    public function remainingQuantity(): float
    {
        return (float) $this->quantity - (float) $this->received_quantity;
    }

    public function isFullyReceived(): bool
    {
        return $this->remainingQuantity() <= 0;
    }
}