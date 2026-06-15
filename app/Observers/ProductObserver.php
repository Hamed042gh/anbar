<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{
    public function created(Product $product): void
    {
        if ($product->isSimple()) {
            $product->variants()->create([
                'sku'        => $product->sku . '-DEFAULT',
                'price'      => 0,
                'cost_price' => 0,
                'is_default' => true,
                'is_active'  => true,
            ]);
        }
    }
}
