<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasFactory;

    protected $table = 'product_variations';
    protected $guarded = [];

    public static function StoreProductVariation($variation, $attributeId, $product ,$key)
    {
        ProductVariation::query()->create([
            'product_id' => $product->id,
            'attribute_id' => $attributeId,
            'value' => $variation['value'][$key],
            'price' => $variation['price'][$key],
            'quantity' => $variation['quantity'][$key],
            'sku' => $variation['sku'][$key],
        ]);
    }
}
