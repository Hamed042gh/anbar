<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'type', 'phone', 'email',
        'address', 'credit_limit', 'balance', 'is_active',
    ];

    protected $casts = [
        'credit_limit' => 'decimal:2',
        'balance'      => 'decimal:2',
        'is_active'    => 'boolean',
    ];

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function isWholesale(): bool
    {
        return $this->type === 'wholesale';
    }

    public function hasCredit(float $amount): bool
    {
        return ($this->balance + $amount) <= $this->credit_limit;
    }
}