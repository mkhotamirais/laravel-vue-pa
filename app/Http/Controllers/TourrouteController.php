<?php

namespace App\Http\Controllers;

use App\Models\Tourroute;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TourrouteController extends Controller
{
    public function index()
    {
        $title = "Tour Package Route";
        $tourroutes = Tourroute::orderBy('name', 'asc')->get();
        $msg = session('msg');

        return inertia('Dashboard/Tourpackage/Tourroute', compact('title', 'tourroutes', 'msg'));
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|max:255|unique:tourroutes',
        ]);

        $fields['slug'] = Str::slug($request->name);

        Tourroute::create($fields);
        return back()->with('msg', "Tour package category '$request->name' berasil ditambahkan");
    }

    public function update(Request $request, Tourroute $tourroute)
    {
        $fields = $request->validate([
            'name' => 'required|max:255|unique:tourroutes,name,' . $tourroute->id,
        ]);

        $fields['slug'] = Str::slug($request->name);

        $tourroute->update($fields);

        return back()->with('msg', "Tourpackage category '$request->name' berasil diupdate");
    }

    public function destroy(Tourroute $tourroute)
    {
        $tourroute->delete();
        return back()->with('msg', "Tourpackage category '$tourroute->name' berasil dihapus");
    }
}
