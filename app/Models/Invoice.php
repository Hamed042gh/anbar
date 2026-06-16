<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'number', 'customer_id', 'warehouse_id', 'user_id', 'price_list_id',
        'status', 'total_amount', 'discount_amount', 'tax_amount',
        'payable_amount', 'paid_amount', 'note', 'issued_at',
    ];

    protected $casts = [
        'total_amount'    => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_amount'      => 'decimal:2',
        'payable_amount'  => 'decimal:2',
        'paid_amount'     => 'decimal:2',
        'issued_at'       => 'datetime',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function priceList(): BelongsTo
    {
        return $this->belongsTo(PriceList::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function remainingAmount(): float
    {
        return (float) $this->payable_amount - (float) $this->paid_amount;
    }

    public function isFullyPaid(): bool
    {
        return $this->remainingAmount() <= 0;
    }

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }
}