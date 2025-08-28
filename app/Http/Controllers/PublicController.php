<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Blogcat;
use App\Models\Carrental;
use App\Models\Tourpackage;
use App\Models\Tourpackagecat;

class PublicController extends Controller
{
    public function home()
    {
        $blogs = Blog::with('blogcat:id,name,slug')->latest()->take(4)->get();
        $carrentals = Carrental::orderByRaw("
                CASE 
                    WHEN category = 'Lepas Kunci' AND price = (SELECT MIN(price) FROM carrentals WHERE category = 'Lepas Kunci') THEN 1
                    WHEN category = 'Lepas Kunci' THEN 2
                    WHEN category = 'Include Driver' AND price = (SELECT MIN(price) FROM carrentals WHERE category = 'Include Driver') THEN 3
                    WHEN category = 'Include Driver' THEN 4
                    ELSE 5
                END
            ")
            ->take(4)->get();
        $tourpackages = Tourpackage::with('tourpackagecat:id,name,slug')->orderBy('price', 'asc')->take(3)->get();
        return inertia('Home', compact('blogs', 'carrentals', 'tourpackages'));
    }

    public function carrental()
    {
        $carrentals = Carrental::filter(request(['carrentalcat']))
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
        $tourpackages = Tourpackage::filter(request(['tourpackagecat']))
            ->with('tourpackagecat:id,name,slug')
            ->latest()
            ->paginate(6);
        $tourpackagecats = Tourpackagecat::orderBy('name', 'asc')->get();
        return inertia('Tourpackage', compact('tourpackages', 'tourpackagecats'));
    }

    public function blog()
    {
        $blogs = Blog::with('blogcat:id,name,slug')->latest()->paginate(8);
        $blogcats = Blogcat::orderBy('name', 'asc')->get();
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
