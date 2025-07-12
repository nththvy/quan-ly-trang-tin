<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getList()
    {
        $roles = Role::paginate(10);
        return view('admin.roles.list', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getCreate()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    public function postCreate(Request $request)
    {
        //Kiem tra
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ]);

        $orm = new Role();
        $orm->name = $request->name;
        $orm->save();

        if (strtolower($orm->name) !== 'user') {
            $orm->syncPermissions($request->input('permissions', []));
        }
    
        return redirect()->route('admin.roles')
            ->with('success', 'Tạo vai trò thành công.');
    }
    public function getUpdate($id)
    {
        $role = Role::with('permissions')->findOrFail($id);

        $permissions = Permission::all();

        // Lấy mảng tên permission đã gán cho role
        $rolePermissions = $role->getPermissionNames()->toArray();

        return view('admin.roles.update', compact('role', 'permissions', 'rolePermissions'));
    }

    public function postUpdate(Request $request, $id)
    {
        // Validate tên và permission nếu có
        $request->validate([
            'name'        => ['required', 'string', 'max:255', "unique:roles,name,{$id}"],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', 'exists:permissions,name'],
        ]);

        // Lấy role và cập nhật tên
        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->save();

        // Cập nhật permissions nếu không phải role 'user'
        if (strtolower($role->name) !== 'user') {
            $role->syncPermissions($request->input('permissions', []));
        } else {
            // Nếu đổi thành 'user' hoặc original là 'user', bỏ hết permission
            $role->syncPermissions([]);
        }

        return redirect()->route('admin.roles')
            ->with('success', 'Cập nhật vai trò thành công.');
    }

    public function getDelete($id)
    {
        $orm = Role::find($id);
        $orm->delete();

        return redirect()->route('admin.roles');
    }
}
