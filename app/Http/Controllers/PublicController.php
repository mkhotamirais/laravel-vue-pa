<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Blogcat;
use App\Models\Carrental;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home()
    {
        $blogs = Blog::with('blogcat:id,name,slug')->latest()->take(4)->get();
        $carrentals = Carrental::latest()->take(4)->get();
        return inertia('Home', compact('blogs', 'carrentals'));
    }

    public function carrental()
    {
        $carrentals = Carrental::filter(request(['rentalcat']))
            ->orderByRaw("
                CASE 
                    WHEN category = 'Lepas Kunci' AND price = (SELECT MIN(price) FROM carrentals WHERE category = 'Lepas Kunci') THEN 1
                    WHEN category = 'Lepas Kunci' THEN 2
                    WHEN category = 'Include Driver' AND price = (SELECT MIN(price) FROM carrentals WHERE category = 'Include Driver') THEN 3
                    WHEN category = 'Include Driver' THEN 4
                    ELSE 5
                END
            ")
            ->paginate(8);

        return inertia('Carrental', compact('carrentals'));
    }

    public function tourpackage()
    {
        return inertia('Tourpackage');
    }

    public function blog()
    {
        $blogs = Blog::with('blogcat:id,name,slug')
            ->latest()->paginate(8);
        $blogcats = Blogcat::latest()->get();
        return inertia('Blog', compact('blogs', 'blogcats'));
    }

    public function blogcat(Blogcat $blogcat)
    {
        $blogs = Blog::with('blogcat:id,name,slug')
            ->where('blogcat_id', $blogcat->id)
            ->latest()->paginate(8);

        $blogcats = Blogcat::latest()->get();

        return inertia('Blog', compact('blogs', 'blogcats'));
    }
}
