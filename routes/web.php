<?php

use App\Http\Controllers\PublicController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [PublicController::class, 'home'])->name('public.home');
Route::get('/sewa-mobil', [PublicController::class, 'carrental'])->name('public.carrental');
Route::get('/paket-wisata', [PublicController::class, 'tourpackage'])->name('public.tourpackage');
Route::get('/blog', [PublicController::class, 'blog'])->name('public.blog');

Route::post('/set-locale', function (Request $request) {
    $locale = $request->input('locale');
    if (in_array($locale, ['en', 'id'])) {
        session(['locale' => $locale]);
    }
    return back();
});
