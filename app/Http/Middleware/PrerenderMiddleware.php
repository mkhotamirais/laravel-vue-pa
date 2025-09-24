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

        $crawlers = ['googlebot', 'bingbot', 'slurp', 'baidubot', 'yandex', 'facebookexternalhit', 'twitterbot'];

        if (str_contains($userAgent, 'Prerender') || !$this->isCrawler($userAgent, $crawlers)) {
            return $next($request);
        }

        $prerenderUrl = 'https://service.prerender.io/https://' . $request->getHost() . $request->getRequestUri();

        // Perbaikan di sini: Tambahkan header Content-Type
        $response = Http::withHeaders([
            'Content-Type' => 'text/html'
        ])->get($prerenderUrl);

        if ($response->successful()) {
            return response($response->body(), $response->status());
        }

        return $next($request);
    }

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
