<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class PrerenderMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userAgent = $request->header('User-Agent');

        // Daftar bot yang ingin kita alihkan ke Prerender.io
        $crawlers = ['googlebot', 'bingbot', 'slurp', 'baidubot', 'yandex', 'facebookexternalhit', 'twitterbot'];

        // Jika User-Agent adalah Prerender.io atau bukan dari bot, lewati middleware ini.
        // Ini untuk mencegah loop tak terbatas dan memastikan pengguna biasa melihat halaman normal.
        if (str_contains($userAgent, 'Prerender') || !$this->isCrawler($userAgent, $crawlers)) {
            return $next($request);
        }

        // Tentukan URL Prerender.io.
        // Ganti 'YOUR_TOKEN' jika Anda menggunakan paket berbayar.
        $prerenderUrl = 'https://service.prerender.io/https://' . $request->getHost() . $request->getRequestUri();
        // Untuk paket berbayar:
        // $prerenderUrl = 'https://service.prerender.io/YOUR_TOKEN/https://' . $request->getHost() . $request->getRequestUri();

        // Lakukan permintaan GET ke Prerender.io
        $response = Http::get($prerenderUrl);

        // Jika permintaan berhasil, kembalikan konten yang sudah dirender.
        if ($response->successful()) {
            return response($response->body(), $response->status());
        }

        // Jika gagal, biarkan permintaan berlanjut ke alur normal.
        return $next($request);
    }

    /**
     * Periksa apakah User-Agent adalah salah satu crawler yang terdaftar.
     */
    protected function isCrawler(string $userAgent, array $crawlers): bool
    {
        foreach ($crawlers as $crawler) {
            if (stripos($userAgent, $crawler) !== false) {
                return true;
            }
        }
        return false;
    }
}
