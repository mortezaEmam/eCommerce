<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use mysql_xdevapi\Exception;

class UserController extends Controller
{
    public function index()
    {

        $users = User::query()->latest()->paginate(10);
        return view('admin.users.index-users', compact('users'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $data = [
            'user' => $user,
            'roles' => $roles,
            'permissions' => $permissions,
            'roles_user' => $user->roles()->pluck('id')->toArray(),
            'permissions_user' => $user->permissions()->pluck('id')->toArray()
        ];
        return view('admin.users.edit-user', $data);
    }


    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'nullable|unique:users,email,' . $user->id,
            'cellphone' => 'nullable|numeric'
        ]);
        if ($validator->fails()) {
            alert()->error('دقت کنید', 'اطلاعات وارد شده نامعتبر می باشد')->persistent('حله');
            return redirect()->back();
        }
        try {
            DB::beginTransaction();

            $user->update([
                'name' => $request->name,
                'cellphone' => $request->cellphone,
                'is_status' => $request->is_status,
                'email' => $request->email,
            ]);
            $user->syncRoles($request->role);
            $permissions = $request->except('name', 'email', '_token', 'cellphone', '_method', 'role', 'is_status');
            $user->syncPermissions($permissions);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();

            alert()->success('خطا', $e->getMessage());
            return redirect()->back();
        }
        alert()->success('با تشکر', 'کاربر با موفقیت ویرایش شد');
        return redirect()->route('admin.users.index');
    }


}
