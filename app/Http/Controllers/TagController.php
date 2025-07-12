<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getList()
    {
        $tags = Tag::paginate(10);
        return view('admin.tags.list', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getCreate()
    {
        return view('admin.tags.create');
    }

    public function postCreate(Request $request)
    {
        //Kiem tra
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:tags'],
        ]);

        $orm = new Tag();
        $orm->name = $request->name;
        $orm->slug = Str::slug($request->name, '-');
        $orm->save();

        return redirect()->route('admin.tags');
    }
    public function getUpdate($id)
    {
        $tag = Tag::find($id);
        return view('admin.tags.update', compact('tag'));
    }

    public function postUpdate(Request $request, $id)
    {
        //Kiem tra
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:tags,name,' . $id],
        ]);
        $orm = Tag::find($id);
        $orm->name = $request->name;
        $orm->slug = Str::slug($request->name, '-');
        $orm->save();

        return redirect()->route('admin.tags');
    }

    public function getDelete($id)
    {
        $orm = Tag::find($id);
        $orm->delete();

        return redirect()->route('admin.tags');
    }
}
