<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InventoryCheck extends Model
{
    protected $fillable = ['warehouse_id', 'user_id', 'status', 'note', 'checked_at'];

    protected $casts = ['checked_at' => 'datetime'];

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(InventoryCheckItem::class);
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }
}
