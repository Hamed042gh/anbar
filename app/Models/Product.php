<?php

namespace App\Models;

use App\Concerns\HasActivityLog;
use App\Models\ProductBarcode;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model  implements HasMedia
{
    use SoftDeletes;
    use HasActivityLog;
     use InteractsWithMedia;

    protected $fillable = [
        'category_id', 'unit_id', 'name', 'sku',
        'description', 'image', 'type', 'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function defaultVariant(): HasOne
    {
        return $this->hasOne(ProductVariant::class)->where('is_default', true);
    }

    public function isSimple(): bool
    {
        return $this->type === 'simple';
    }

    public function isVariable(): bool
    {
        return $this->type === 'variable';
    }

    public function isManufactured(): bool
    {
        return $this->type === 'manufactured';
    }

    public function registerMediaCollections(): void
    {
        // $this->addMediaCollection('featured')->singleFile();
        $this->addMediaCollection('gallery');
    }

    public function barcodes(): HasManyThrough
    {
        return $this->hasManyThrough(
            ProductBarcode::class,
            ProductVariant::class,
            'product_id',
            'variant_id', 
        );
    }
}
