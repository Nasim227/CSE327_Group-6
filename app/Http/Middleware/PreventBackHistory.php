<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Prevents browser back button from showing cached pages after logout.
 * 
 * Sets HTTP headers that disable caching, forcing the browser to
 * request fresh content instead of showing stale cached pages.
 * 
 * @package App\Http\Middleware
 */
class PreventBackHistory
{
    /**
     * Handle an incoming request.
     * 
     * Adds cache-control headers to prevent browser caching.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Set headers to prevent browser caching
        return $response->withHeaders([
            'Cache-Control' => 'nocache, no-store, max-age=0, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => 'Sun, 02 Jan 1990 00:00:00 GMT',
        ]);
    }
}
