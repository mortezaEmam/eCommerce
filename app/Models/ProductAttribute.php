<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $table = 'product_attributes';
    protected $guarded = [];

    public static function StoreProductAttributes($attributes,Product $product)
    {
        foreach ($attributes as $key => $value) {
            ProductAttribute::query()->create([
                'product_id' => $product->id,
                'attribute_id' => $key,
                'value' => $value
            ]);
        }
    }
    public static function UpdateProductAttributes($attributesIds)
    {
        foreach ($attributesIds as $key => $value) {
            $productAttribute = ProductAttribute::query()->findOrFail($key);
            $productAttribute->update([
                'value' => $value
            ]);
        }
    }
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
