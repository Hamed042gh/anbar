<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceItem extends Model
{
    protected $fillable = [
        'invoice_id', 'variant_id', 'quantity',
        'unit_price', 'discount_amount', 'total_price',
    ];

    protected $casts = [
        'quantity'        => 'decimal:3',
        'unit_price'      => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_price'     => 'decimal:2',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }
}