<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class ForceHttps
{
    /**
     * Force the application URL to match the incoming request's host.
     * This lets any Cloudflare tunnel URL work without hardcoding it in .env
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If request came through a trusted proxy (Cloudflare), force the scheme & host
        if ($request->isSecure() || $request->header('X-Forwarded-Proto') === 'https') {
            URL::forceScheme('https');
        }

        // Force root URL to use the actual incoming host (tunnel URL)
        $forwardedHost = $request->header('X-Forwarded-Host');
        if ($forwardedHost) {
            $scheme = $request->isSecure() || $request->header('X-Forwarded-Proto') === 'https'
                ? 'https'
                : 'http';
            URL::forceRootUrl($scheme . '://' . $forwardedHost);
        }

        return $next($request);
    }
}
