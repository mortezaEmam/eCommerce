<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAddressController extends Controller
{
    public function index()
    {
        $user_addresses = UserAddress::query()->where('user_id' , Auth::id())->get();
        $provinces = Province::all();
        $data = [
           'user_addresses' => $user_addresses,
           'provinces' => $provinces,
        ];
        return view('home.users.user_profile.index',$data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validateWithBag('addressStore', [
            'title' => 'required',
            'phone' => 'required|iran_mobile',
            'province_id' => 'required',
            'city_id' => 'required',
            'address' => 'required',
            'postal_code' => 'required|iran_postal_code'
        ]);
        try {
            UserAddress::create([
                'user_id' => auth()->id(),
                'title' => $request->title,
                'phone' => $request->phone,
                'province_id' => $request->province_id,
                'city_id' => $request->city_id,
                'address' => $request->address,
                'postal_code' => $request->postal_code
            ]);

            alert()->success( 'باتشکر','آدرس مورد نظر ایجاد شد');
            return redirect()->back();
        }catch (\Exception)
        {
            alert()->error( 'اووه مشکلی هست', 'در ذخیره سازی اطلاعات مشکلی پیش آمده است');
            return redirect()->back();
        }
    }

    public function show(UserAddress $userAddress)
    {
        //
    }

    public function edit(UserAddress $userAddress)
    {
        //
    }

    public function update(Request $request, UserAddress $userAddress)
    {
        //
    }

    public function destroy(UserAddress $userAddress)
    {
        //
    }
}
