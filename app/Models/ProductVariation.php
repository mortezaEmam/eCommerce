<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    use HasFactory;

    protected $table = 'product_variations';
    protected $guarded = [];

    public static function StoreProductVariation($variation, $attributeId, $product, $key)
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

    public static function UpdateProductVariation($variationIds)
    {
        foreach ($variationIds as $key => $value) {
            $productVariation = ProductVariation::findOrFail($key);
            $productVariation->update([
                'price' => $value['price'],
                'quantity' => $value['quantity'],
                'sku' => $value['sku'],
                'sale_price' => $value['sale_price'],
                'date_on_sale_from' => $value['date_on_sale_from'] == null ? null : convertShamsiToGregorianDate($value['date_on_sale_from']),
                'date_on_sale_to' => $value['date_on_sale_from'] == null ? null : convertShamsiToGregorianDate($value['date_on_sale_to']),
            ]);
        }
    }
}
