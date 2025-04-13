<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifiedAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->is_verified || $request->user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Only administrators can access this area.');
        }

        return $next($request);
    }
} 