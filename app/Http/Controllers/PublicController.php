<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home()
    {
        return inertia('Home');
    }

    public function carrental()
    {
        return inertia('Carrental');
    }

    public function tourpackage()
    {
        return inertia('Tourpackage');
    }

    public function blog()
    {
        return inertia('Blog');
    }
}
