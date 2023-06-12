<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use PHPUnit\Exception;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::query()->latest()->paginate(10);
        return view('admin.coupons.index',compact('coupons'));
    }
    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
        'name' => 'required',
        'code' => 'required|unique:coupons,code',
        'type' => 'required',
        'amount' => 'required_if:type,=,amount',
        'percentage' => 'required_if:type,=,percentage',
        'max_percentage_amount' => 'required_if:type,=,percentage',
        'expired_at' => 'required'
    ]);

        Coupon::create([
            'name' => $request->name,
            'code' => $request->code,
            'type' => $request->type,
            'amount' => $request->amount,
            'percentage' => $request->percentage,
            'max_percentage_amount' => $request->max_percentage_amount,
            'expired_at' => convertShamsiToGregorianDate($request->expired_at)
        ]);

        alert()->success( 'باتشکر','کوپن مورد نظر ایجاد شد');
        return redirect()->route('admin.coupons.index');
    }
    public function show(Coupon $coupon)
    {

        return view('admin.coupons.show',compact('coupon'));
    }
    public function edit(Coupon $coupon)
    {

        return view('admin.coupons.edit',compact('coupon'));
    }
    public function update(Request $request,Coupon $coupon)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required',
            'type' => 'required',
            'amount' => 'required_if:type,=,amount',
            'percentage' => 'required_if:type,=,percentage',
            'max_percentage_amount' => 'required_if:type,=,percentage',
            'expired_at' => 'required'
        ]);
        try {
            $coupon->update([
                'name' => $request->name,
                'code' => $request->code,
                'type' => $request->type,
                'amount' => $request->amount,
                'percentage' => $request->percentage,
                'max_percentage_amount' => $request->max_percentage_amount,
                'expired_at' => convertShamsiToGregorianDate($request->expired_at)
            ]);
            alert()->success('باتشکر','کوپن مورد نظر با موفقیت ویرایش شد');
            return redirect()->route('admin.coupons.index');
        }
        catch (Exception $e)
        {
            alert()->success('دقت کنید',$e->getMessage());
            return redirect()->back();
        }

    }
}
