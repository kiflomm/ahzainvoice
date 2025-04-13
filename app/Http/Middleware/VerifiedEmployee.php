<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifiedEmployee
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->is_verified || !in_array($request->user()->role, ['employee', 'admin'])) {
            return redirect()->route('dashboard')->with('error', 'Only verified employees can access this area.');
        }

        return $next($request);
    }
} 