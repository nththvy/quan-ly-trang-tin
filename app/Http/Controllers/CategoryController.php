<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getList()
    {
        $categories = Category::paginate(10);
        return view('admin.categories.list', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getCreate()
    {
        return view('admin.categories.create');
    }

    public function postCreate(Request $request)
    {
        //Kiem tra
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories'],
        ]);

        $orm = new Category();
        $orm->name = $request->name;
        $orm->slug = Str::slug($request->name, '-');
        $orm->save();

        return redirect()->route('admin.categories');
    }
    public function getUpdate($id)
    {
        $category = Category::find($id);
        return view('admin.categories.update', compact('category'));
    }

    public function postUpdate(Request $request, $id)
    {
        //Kiem tra
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,' . $id],
            ]);
        $orm = Category::find($id);
        $orm->name = $request->name;
        $orm->slug = Str::slug($request->name, '-');
        $orm->save();

        return redirect()->route('admin.categories');
    }

    public function getDelete($id)
    {
        $orm = Category::find($id);
        $orm->delete();

        return redirect()->route('admin.categories');
    }
}
