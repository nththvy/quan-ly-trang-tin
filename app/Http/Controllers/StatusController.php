<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getList()
    {
        $statuses = Status::paginate(10);
        return view('admin.statuses.list', compact('statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getCreate()
    {
        return view('admin.statuses.create');
    }

    public function postCreate(Request $request)
    {
        //Kiem tra
        $request->validate([
            'status' => ['required', 'string', 'max:255', 'unique:statuses'],
        ]);

        $orm = new Status();
        $orm->status = $request->status;
        $orm->save();

        return redirect()->route('admin.statuses');
    }
    public function getUpdate($id)
    {
        $status = Status::find($id);
        return view('admin.statuses.update', compact('status'));
    }

    public function postUpdate(Request $request, $id)
    {
        //Kiem tra
        $request->validate([
            'status' => ['required', 'string', 'max:255', 'unique:statuses,status,' . $id],
            ]);
        $orm = Status::find($id);
        $orm->status = $request->status;
        $orm->save();

        return redirect()->route('admin.statuses');
    }

    public function getDelete($id)
    {
        $orm = Status::find($id);
        $orm->delete();

        return redirect()->route('admin.statuses');
    }
}
