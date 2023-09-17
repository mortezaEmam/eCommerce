<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
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
            'name' => 'required',
            'display_name' => 'required',
        ]);
        Permission::query()->create([
            'display_name' => $request->display_name,
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        alert()->success('باتشکر','پرمیژن مورد نظر ایجاد شد');
        return redirect()->route('admin.permissions.index');
    }

    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required',
            'display_name' => 'required',
        ]);
        $permission->update([
            'display_name' => $request->display_name,
            'name' => $request->name,
        ]);

        alert()->success('باتشکر','پرمیژن مورد نظر ویرایش شد');
        return redirect()->route('admin.permissions.index');
    }

}
