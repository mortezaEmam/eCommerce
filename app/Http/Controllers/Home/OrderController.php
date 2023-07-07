<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Order;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function usersProfileIndex()
    {
        $orders =  Order::query()->where('user_id',Auth::id())->paginate(10);
        return view('home.users.user_profile.index',compact('orders'));
    }

    public function showOrderDetail(Request $request)
    {
        $order = Order::query()->findOrFail($request->order_id)->with('orderItems');
        $order_details = $order->orderItems;

        $view = view('home.users.user_profile.sections.model_order_detail',compact('order_details'))->render();
        return response()->json(['view'=>$view]);

    }
}
