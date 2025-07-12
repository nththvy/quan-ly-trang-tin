<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getList()
    {
        $users = User::with('role')->paginate(10);
        return view('admin.users.list', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getCreate()
    {
        $roles = Role::pluck('name', 'id'); // Lấy danh sách role ['id' => 'name']
        return view('admin.users.create', compact('roles'));
    }

    public function postCreate(Request $request)
    {
        //Kiem tra
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role_id' => ['required'],
            'password' => ['required', 'min:4', 'confirmed'],
            'image' => ['nullable', 'image', 'max:1024']
        ]);

        // Upload hình ảnh 
        $path = '';
        if ($request->hasFile('image')) {
            $extension = $request->file('image')->extension();
            $filename = Str::slug($request->name, '-') . '.' . $extension;
            $path = Storage::putFileAs('user', $request->file('image'), $filename);
        } else {
            $path = 'public/placeholders/user_placeholder.jpg'; // Đường dẫn trong storage/app
        }
        $orm = new User();
        $orm->name = $request->name;
        $orm->email = $request->email;
        $orm->password = Hash::make($request->password);
        $orm->role_id = $request->role_id;
        if (!empty($path)) $orm->image = $path;
        $orm->save();

        $role = Role::findOrFail($request->role_id);
        $orm->assignRole($role->name);

        return redirect()->route('admin.users');
    }
    public function getUpdate($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'id');

        return view('admin.users.update', compact('user', 'roles'));
    }

    public function postUpdate(Request $request, $id)
    {
        //Kiem tra
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'role_id' => ['required'],
            'password' => ['confirmed'],
            'image' => ['nullable', 'image', 'max:1024']
        ]);

        // Upload hình ảnh 
        $path = '';
        if ($request->hasFile('image')) {
            // Xóa file cũ 
            $orm = User::find($id);
            if (!empty($orm->image)) Storage::delete($orm->image);

            // Upload file mới 
            $extension = $request->file('image')->extension();
            $filename = Str::slug($request->name, '-') . '.' . $extension;
            $path = Storage::putFileAs('user', $request->file('image'), $filename);
        }

        $orm = User::findOrFail($id);
        $orm->name = $request->name;
        $orm->email = $request->email;
        if ($request->filled('password')) {
            $orm->password = Hash::make($request->password);
        }
        $orm->role_id = $request->role_id;
        if (!empty($path)) $orm->image = $path;

        if ($orm->save()) {
            // Nếu lưu thành công, mới gán lại role
            $role = Role::findOrFail($request->role_id);
            $orm->syncRoles([$role->name]);

            return redirect()->route('admin.users')->with('success', 'Cập nhật thành công!');
        } else {
            return back()->with('error', 'Cập nhật thất bại!');
        }
    }

    public function getDelete($id)
    {
        $orm = User::find($id);
        $orm->delete();
        if (!empty($orm->image)) Storage::delete($orm->image); //xoa img khi xoa nguoi dung
        return redirect()->route('admin.users');
    }

    public function getProfile()
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Bạn chưa đăng nhập!');
        }

        return view('user.profile', compact('user'));
    }
    public function postProfile(Request $request)
    {
        $id = Auth::id();

        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'password' => ['nullable', 'confirmed'],
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($user->image && Storage::exists($user->image)) {
                Storage::delete($user->image);
            }

            // Lưu ảnh mới
            $path = $request->file('image')->store('users');
            $user->image = $path;
        }

        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Đã cập nhật thông tin thành công.');
    }
}
