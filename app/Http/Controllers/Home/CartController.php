<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Http\Request;
use Cart;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'qtybutton' => 'required|integer',
            'product_id' => 'required',
        ]);
        $product = Product::query()->findOrFail($request->product_id);
        $productVariaton = ProductVariation::query()->findOrFail(json_decode($request->variation)->id);
        if ($request->qtybutton > $productVariaton->quantity) {
            alert()->warning('دقت کنید', 'تعداد محصول وارد شده با موجودی انبار مطابقت ندارد');
            return redirect()->back();
        }
        $rowId = $product->id . '-' . $productVariaton->id;
        if (Cart::get($rowId) == null) {
            // add the product to cart
            Cart::add(array(
                'id' => $rowId,
                'name' => $product->name,
                'price' => $product->sale_check ? $productVariaton->sale_price : $productVariaton->price,
                'quantity' => $request->qtybutton,
                'attributes' => $productVariaton->toArray(),
                'associatedModel' => $product
            ));
        } else {
            alert()->warning('دقت کنید', 'محصول مورد نظر قبلا به سبد خرید شما اضافه شده است');
            return redirect()->back();
        }
        alert()->success('با تشکر', 'محصول با موفقیت به سبد خرید شما افزوده شد');
        return redirect()->back();
    }
}
