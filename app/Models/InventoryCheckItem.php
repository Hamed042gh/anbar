<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryCheckItem extends Model
{
    protected $fillable = [
        'inventory_check_id', 'variant_id',
        'system_quantity', 'actual_quantity', 'note',
    ];

    protected $casts = [
        'system_quantity' => 'decimal:3',
        'actual_quantity' => 'decimal:3',
    ];

    public function inventoryCheck(): BelongsTo
    {
        return $this->belongsTo(InventoryCheck::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function getDifferenceAttribute(): float
    {
        return (float) $this->actual_quantity - (float) $this->system_quantity;
    }
}
