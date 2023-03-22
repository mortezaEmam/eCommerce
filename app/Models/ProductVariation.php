<?php

namespace App\Models;

use App\Http\Requests\ProductCategoryRequest;
use http\Env\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariation extends Model
{
    use HasFactory,SoftDeletes;

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

    public static function ChangeProductVariation(ProductCategoryRequest $request, Product $product)
    {
        ProductVariation::query()->where('product_id',$product->id)->delete();
        $category = Category::query()->find($request->category_id);
        $attribute_id = $category->attributes()->wherePivot('is_variation', 1)->first()->id;

        for ($i = 0; $i < count($request->attribute_variation['value']); $i++) {
            ProductVariation::query()->create([
                'product_id' => $product->id,
                'attribute_id' => $attribute_id,
                'value' => $request->attribute_variation['value'][$i],
                'price' => $request->attribute_variation['price'][$i],
                'quantity' => $request->attribute_variation['quantity'][$i],
                'sku' => $request->attribute_variation['sku'][$i],
            ]);
        }
    }
}
