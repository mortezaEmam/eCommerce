<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use mysql_xdevapi\Exception;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()->latest()->paginate(10);
        return view('admin.users.index-users',compact('users'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit-user',compact('user'));
    }


    public function update(Request $request,User $user)
    {
        try {
            $validator = Validator::make($request->all(),[
                'name' => 'required|string',
                'email' => 'nullable|unique:users,email,'.$user->id,
                'cellphone' => 'nullable|numeric'
            ]);
            if ($validator->fails()){
                alert()->error('دقت کنید', 'اطلاعات وارد شده نامعتبر می باشد')->persistent('حله');
                return redirect()->back();
            }

            $user->update($request->all());

            alert()->success('با تشکر', 'کاربر با موفقیت ویرایش شد');
            return redirect()->route('admin.users.index');
        }catch (Exception $e){
            alert()->success('اوه', $e->getMessage());
            return redirect()->route('admin.users.index');
        }

    }


}
