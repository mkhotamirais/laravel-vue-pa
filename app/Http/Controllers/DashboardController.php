<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Carrental;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $title = "Dashboard";

        $blogs = Blog::with('blogcat:id,name,slug')->latest()->take(4)->get();
        $totalBlogs = Blog::count();

        $carrentals = Carrental::latest()->take(4)->get();
        $totalCarrentals = Carrental::count();
        return inertia('Dashboard/Index', compact('title', 'blogs', 'totalBlogs', 'carrentals', 'totalCarrentals'));
    }
}
