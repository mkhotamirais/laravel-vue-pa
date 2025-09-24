<?php

use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\PrerenderMiddleware;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            HandleInertiaRequests::class,
            PrerenderMiddleware::class
        ]);
    })
    ->withSchedule(function (Schedule $schedule) {
        // Tambahkan perintah sitemap Anda di sini
        $schedule->command('app:generate-sitemap')->dailyAt('02:00');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
