<?php

namespace App\Http\Controllers;

use App\Models\Tourpackagecat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TourpackagecatController extends Controller
{
    public function index()
    {
        $title = "Tour Package Category";
        $tourpackagecats = Tourpackagecat::latest()->paginate(8);
        $msg = session('msg');

        return inertia('Dashboard/Tourpackage/Tourpackagecat', compact('title', 'tourpackagecats', 'msg'));
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|max:255|unique:tourpackagecats',
        ]);

        $fields['slug'] = Str::slug($request->name);

        Tourpackagecat::create($fields);
        return back()->with('msg', "Tour package category '$request->name' berasil ditambahkan");
    }

    public function update(Request $request, Tourpackagecat $tourpackagecat)
    {
        $fields = $request->validate([
            'name' => 'required|max:255|unique:tourpackagecats,name,' . $tourpackagecat->id,
        ]);

        $fields['slug'] = Str::slug($request->name);

        $tourpackagecat->update($fields);

        return back()->with('msg', "Tourpackage category '$request->name' berasil diupdate");
    }

    public function destroy(Tourpackagecat $tourpackagecat)
    {
        $tourpackagecat->delete();
        return back()->with('msg', "Tourpackage category '$tourpackagecat->name' berasil dihapus");
    }
}
