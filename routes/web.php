<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CarrentalController;
use App\Http\Controllers\PublicController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [PublicController::class, 'home'])->name('public.home');

Route::get('/rental-mobil', [PublicController::class, 'carrental'])->name('public.carrental');
Route::get('/rental-mobil/{carrental}', [CarrentalController::class, 'show'])->name('public.carrental.show');

Route::get('/paket-wisata', [PublicController::class, 'tourpackage'])->name('public.tourpackage');

Route::get('/blog', [PublicController::class, 'blog'])->name('public.blog');
Route::get('/blog/{blog}', [BlogController::class, 'show'])->name('public.blog.show');
Route::get('/blog/category/{blogcat}', [PublicController::class, 'blogcat'])->name('public.blog.category');

Route::post('/set-locale', function (Request $request) {
    $locale = $request->input('locale');
    if (in_array($locale, ['en', 'id'])) {
        session(['locale' => $locale]);
    }
    return back();
});

require __DIR__ . '/protected.php';
require __DIR__ . '/auth.php';
