<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TourpackageController extends Controller
{
    public function index()
    {
        return inertia('Tourpackage');
    }
}
