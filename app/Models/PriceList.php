<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PriceList extends Model
{
    protected $fillable = ['name', 'type', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function items(): HasMany
    {
        return $this->hasMany(PriceListItem::class);
    }

    public function priceFor(int $variantId): ?float
    {
        return $this->items()
            ->where('variant_id', $variantId)
            ->value('price');
    }
}