<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PrerenderMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Daftar user agent bot yang ingin kita prerender
        $bots = [
            'googlebot',
            'bingbot',
            'slurp',
            'duckduckbot',
            'yandexbot',
            'baidubot',
            'facebookexternalhit',
            'linkedinbot',
            'twitterbot',
            'pinterestbot',
            'slackbot',
            'whatsapp'
        ];

        $userAgent = strtolower($request->header('User-Agent'));
        $isBot = false;

        foreach ($bots as $bot) {
            if (strpos($userAgent, $bot) !== false) {
                $isBot = true;
                break;
            }
        }

        // Jika user agent adalah bot DAN bukan permintaan dari Prerender.io sendiri
        if ($isBot && strpos($userAgent, 'prerender') === false) {
            $client = new Client();
            $url = 'https://service.prerender.io/' . urlencode($request->fullUrl());

            // Tambahkan token jika Anda menggunakan versi berbayar
            // $url = 'https://service.prerender.io/YOUR_TOKEN/' . urlencode($request->fullUrl());

            try {
                $response = $client->get($url, ['http_errors' => false]);

                // Mengembalikan response dari Prerender.io
                return response($response->getBody(), $response->getStatusCode())
                    ->withHeaders($response->getHeaders());
            } catch (\Exception $e) {
                // Jika terjadi error, lanjutkan ke request normal
                return $next($request);
            }
        }

        return $next($request);
    }
}
