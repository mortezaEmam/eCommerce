<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Province;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $data =[
            'products_cart' => Cart::getContent(),
            'total_cart' => Cart::getTotal(),
            'is_empty_cart' => Cart::isEmpty(),
            'delivery_amount_products' =>getDeliveryAmountProduct(),
            'amount_percent_sale_product' => getPriceTotalAmountPercentProducts(),
            ];
        return view('home.cart.index',$data);
    }
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

    public function update(Request $request)
    {
        $request->validate([
            'qtybutton' => 'required',
        ]);
        foreach ($request->qtybutton as $rowId => $quantity)
        {
            $item = Cart::get($rowId);
            if ($quantity > $item->attributes->quantity) {
                alert()->warning('دقت کنید', 'تعداد محصول وارد شده با موجودی انبار مطابقت ندارد');
                return redirect()->back();
             }
            Cart::update($rowId, array(
                'quantity' => array(
                    'relative' => false,//برای اینکه کلا مقدار فعلی را جای گزین مقدار قبلی کنیم راه کار این پکیج بود
                    'value' => $quantity
                ),
            ));

        }
        alert()->success('با تشکر', 'سبد خرید شما با موفقیت ویرایش شد');
        return redirect()->back();

    }

    public function remove($rowId)
    {
        Cart::remove($rowId);

        alert()->success('با تشکر', 'محصول با موفقیت از سبد خرید شما حذف شد');
        return redirect()->back();
    }

    public function clear()
    {
        Cart::clear();

        alert()->warning('دقت کنید', 'سبد خرید شما پاک شد');
        return redirect()->back();
    }

    public function checkCoupon(Request $request)
    {
        if(!Auth::check())
        {
            alert()->warning('دقت کنید', 'برای استفاده از کد تخفیف ابتدا باید وارد وب سایت شوید');
            return redirect()->back();
        }
        $request->validate([
            'code'=>'required',
        ]);

        $result = checkCoupon($request->code);

        if (array_key_exists('error',$result))
        {
          alert()->error('دقت کنید',$result['error']);
        }
        else{
            alert()->success('با تشکر',$result['success']);
        }
        return  redirect()->back();
    }

    public function checkout()
    {
        if(\Cart::isEmpty())
        {
            alert()->warning('دقت کنید','سبد خرید شما خالی می باشد ابتدا محصولات مورد نظر خود را انتخاب نمایید');
            return redirect()->route('home.index');
        }
        $data =[
            'products_cart' => Cart::getContent(),
            'total_cart' => Cart::getTotal(),
            'is_empty_cart' => Cart::isEmpty(),
            'delivery_amount_products' =>getDeliveryAmountProduct(),
            'amount_percent_sale_product' => getPriceTotalAmountPercentProducts(),
            'addresses' => UserAddress::query()->where('user_id',Auth::id())->get(),
            'provinces' => Province::all(),
        ];
        return view('home.cart.checkout',$data);
    }
}
