<?php

use App\Http\Controllers\BlogcatController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CarrentalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TourpackagecatController;
use App\Http\Controllers\TourpackageController;
use App\Http\Controllers\TourrouteController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::middleware('verified')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('/dashboard/blogcat', BlogcatController::class)->except(['create', 'show', 'edit']);
        Route::resource('/dashboard/blog', BlogController::class)->except(['show']);

        Route::resource('/dashboard/rental-mobil', CarrentalController::class)
            ->parameters(['rental-mobil' => 'carrental'])
            ->except(['show']);

        Route::resource('/dashboard/paket-wisata', TourpackageController::class)
            ->parameters(['paket-wisata' => 'tourpackage'])
            ->except(['show']);
        Route::resource('/dashboard/tourpackagecat', TourpackagecatController::class)->except(['create', 'show', 'edit']);
        Route::resource('/dashboard/tourroute', TourrouteController::class)->except(['create', 'show', 'edit']);
    });
});
