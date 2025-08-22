<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CarrentalController extends Controller
{
    public function index()
    {
        return inertia('Carrental');
    }
}
