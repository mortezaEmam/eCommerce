<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CompareController extends Controller
{
    public function index()
    {
        if(Session::has('compare_product')) {
            $products = Product::query()->findOrFail(Session::get('compare_product'));
            if (filled($products)) {
                return view('home.compare.index', compact('products'));
            }
        }
        else {
            alert()->warning('دقت کنید', 'لیست مقایسه شما خالی هست در ابتدا لطفا محصولات مورد نظر خود را اضافه کنید');
            return redirect()->route('home.index');
        }
    }
    public function add(Product $product)
    {
        if(Session::has('compare_product'))
        {
            if (in_array($product->id,Session::get('compare_product')))
            {
                alert()->warning('دقت کنید','این محصول قبلا به لیست مقایسه شما افزوده شده است');
                return  redirect()->back();
            }
            else{
                Session::push('compare_product',$product->id);

                alert()->success('با تشکر','محصول با موفقیت به لیست مقایسه شما افزوده شد');
                return redirect()->back();
            }
        }
        else{

            Session::put('compare_product',[$product->id]);
            alert()->success('با تشکر','محصول با موفقیت به لیست مقایسه شما افزوده شد');
            return redirect()->back();
        }

    }

    public function remove($productId)
    {
        if(Session::has('compare_product'))
        {
            foreach (Session::get('compare_product') as $key=>$item)
            {
                if($item == $productId)
                {
                    Session::pull('compare_product.'.$key);
                }
            }
            if(Session::get('compare_product') == [])
            {
                Session::forget('compare_product');
                return redirect()->route('home.compare.index');
            }
        }
        return  redirect()->route('home.compare.index');
    }
}
