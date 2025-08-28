<?php

namespace App\Http\Controllers;

use App\Models\Blogcat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogcatController extends Controller
{
    public function index()
    {
        // halo
        $title = "Blog Categoryyy";
        $blogcats = Blogcat::latest()->paginate(8);
        $msg = session('msg');
        return inertia('Dashboard/Blog/Blogcat', compact('title', 'blogcats', 'msg'));
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|max:255|unique:blogcats',
        ]);

        $fields['slug'] = Str::slug($request->name);

        Blogcat::create($fields);

        return back()->with('msg', "Blog category '$request->name' berasil ditambahkan");
    }

    public function update(Request $request, Blogcat $blogcat)
    {
        $fields = $request->validate([
            'name' => 'required|max:255|unique:blogcats,name,' . $blogcat->id,
        ]);

        $fields['slug'] = Str::slug($request->name);

        $blogcat->update($fields);

        return back()->with('msg', "Blog category '$request->name' berasil diupdate");
    }

    public function destroy(Blogcat $blogcat)
    {
        $blogcat->delete();
        return back()->with('msg', "Blog category '$blogcat->name' berasil dihapus");
    }
}
