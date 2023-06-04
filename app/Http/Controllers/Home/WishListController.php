<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishListController extends Controller
{
    public function add(Product $product)
    {
        $user_id = Auth::id();
        if (Auth::check()) {
            if ($product->checkUserWishlist($user_id)) {
                alert()->warning('اوه', 'محصول قبلا به لیست علاقه مندی های شما افزوده شده است');
                return redirect()->back();
            } else {
                Wishlist::query()->create([
                    'user_id' => $user_id,
                    'product_id' => $product->id,
                ]);
                alert()->success('با تشکر', 'محصول به لیست علاقه مندی های شما افزوده شد');
                return redirect()->back();
            }
        } else {
            alert()->error(' مشکلی هست', 'برای افزودن محصول به لیست علاقه مندی ها باید عضو باشید');
            return redirect()->back();
        }
    }

    public function remove(Product $product)
    {
        $user_id = Auth::id();
        if (Auth::check()) {
            Wishlist::query()->where('user_id', $user_id)->where('product_id', $product->id)->delete();
            alert()->success('با تشکر', 'محصول از لیست علاقه مندی های شما حذف شد');
            return redirect()->back();
        }
        else {
            alert()->error(' مشکلی هست', 'برای حذف محصول از لیست علاقه مندی ها باید عضو باشید');
            return redirect()->back();
        }
    }
}
