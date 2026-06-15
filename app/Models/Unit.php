<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    protected $fillable = ['name', 'symbol'];

    public function conversionsFrom(): HasMany
    {
        return $this->hasMany(UnitConversion::class, 'from_unit_id');
    }

    public function convertTo(Unit $target): ?float
    {
        return $this->conversionsFrom()
            ->where('to_unit_id', $target->id)
            ->value('factor');
    }
}
