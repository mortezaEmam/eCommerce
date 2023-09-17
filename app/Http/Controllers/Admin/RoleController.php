<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::query()->latest()->paginate('10');
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create',compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'display_name' => 'required',
        ]);
        try {
            DB::beginTransaction();
            $role = Role::query()->create([
                'display_name' => $request->display_name,
                'name' => $request->name,
                'guard_name' => 'web',
            ]);

            $permissions = $request->except('name', 'display_name', '_token');
            $role->givePermissionTo($permissions);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            alert()->success('خطا', $e->getMessage());
            return redirect()->back();
        }
        alert()->success('باتشکر', 'نقش مورد نظر ایجاد شد');
        return redirect()->route('admin.roles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $data=[
            'role' => $role,
            'permissions_role' => $role->permissions,
            ];
        return view('admin.roles.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $role_permissions = $role->permissions()->pluck('id')->toArray();

        $data = [
            'role' => $role,
            'permissions' => $permissions,
            'role_permissions' => $role_permissions,
        ];

        return view('admin.roles.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required',
            'display_name' => 'required',
        ]);
        try {
            DB::beginTransaction();
            $role->update([
                'display_name' => $request->display_name,
                'name' => $request->name
            ]);
            $permissions = $request->except('_method','name', 'display_name', '_token');
            $role->syncPermissions($permissions);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            alert()->success('خطا', $e->getMessage());
            return redirect()->back();
        }
        alert()->success('باتشکر', 'نقش مورد نظر ویرایش شد');
        return redirect()->route('admin.roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
