<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Product;
use App\Models\ProductRates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(),
        [
            'text' => 'required|min:5|max:7000',
            'rate' => 'required|digits_between:0,5',
        ]);
        if($validator->fails())
        {
           return redirect()->to(url()->previous() . '#comments')->withErrors($validator->errors());
        }
        if(Auth::check()) {
            try {
                DB::beginTransaction();
                $user_id = Auth::id();
                Comment::create([
                    'user_id' => $user_id,
                    'product_id' => $product->id,
                    'text' => $request->text
                ]);

                if ($product->rates()->where('user_id', $user_id)->exists()) {
                    $rateProduct = $product->rates()->where('user_id', $user_id)->first();
                    $rateProduct->update([
                        'rate' => $request->rate,
                    ]);
                } else {
                    ProductRates::create([
                        'user_id' => $user_id,
                        'product_id' => $product->id,
                        'rate' => $request->rate,
                    ]);
                }

                DB::commit();
            } catch (\Exception $ex) {
                DB::rollBack();
                alert()->error('اوه', 'مشکلی در ثبت نظر پیش امده دوباره تلاش کنید')->persistent('حله');
                return redirect()->back();
            }


            alert()->success('باتشکر','نظر ارزشمند شما برای این محصول با موفقیت ثبت شد' );
            return redirect()->back();
        }
        else{
            alert()->warning('دقت کنید','برای ثبت نظر نیاز هست در ابتدا وارد سایت شوید' )->persistent('حله');
            return redirect()->back();
        }
    }

    public function usersProfileIndex()
    {
        $comments = Comment::query()->where('user_id',Auth::id())->where('approved',1)->with('product')->get();
        return view('home.users.user_profile.index',compact('comments'));
    }
}
