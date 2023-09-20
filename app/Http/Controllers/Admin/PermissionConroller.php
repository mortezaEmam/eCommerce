<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Exception;
use Illuminate\Http\Request;

class PermissionConroller extends Controller
{
    public function index()
    {
        $permissions = Permission::query()->latest()->paginate(10);
        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
            'display_name' => 'required',
        ]);
        try {
            Permission::query()->create([
                'display_name' => $request->display_name,
                'name' => $request->name,
                'guard_name' => 'web',
            ]);
            alert()->success('باتشکر', 'پرمیژن مورد نظر ایجاد شد');
            return redirect()->route('admin.permissions.index');
        } catch (Exception $e) {
            alert()->success('اوه', $e->getMessage());
            return redirect()->route('admin.permissions.index');
        }

    }

    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,'.$permission->id,
            'display_name' => 'required',
        ]);

        try {
            $permission->update([
                'display_name' => $request->display_name,
                'name' => $request->name,
            ]);

            alert()->success('باتشکر', 'پرمیژن مورد نظر ویرایش شد');
            return redirect()->route('admin.permissions.index');

        } catch (\Exception $e) {
            alert()->success('اوه', $e->getMessage());
            return redirect()->route('admin.permissions.index');
        }
    }

}
