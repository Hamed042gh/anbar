<?php

namespace App\Models;

use App\Models\Province;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends Model
{
    use HasFactory;

    protected $fillable = [];
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }
}
