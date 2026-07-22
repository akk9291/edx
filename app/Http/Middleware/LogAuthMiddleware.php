<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogAuthMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        Log::info('=== Auth Middleware Check ===', [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'authenticated' => auth()->check(),
            'user_id' => auth()->id(),
            'session_id' => $request->session()->getId(),
            'has_csrf' => $request->has('_token'),
        ]);

        if (!auth()->check()) {
            Log::warning('=== Auth Middleware: User NOT authenticated - redirecting ===', [
                'url' => $request->fullUrl(),
                'session_id' => $request->session()->getId(),
            ]);
        }

        return $next($request);
    }
}
