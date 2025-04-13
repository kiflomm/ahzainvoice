<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsVerified
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()->is_verified) {
            auth()->logout();
            return redirect()->route('login')
                ->with('error', 'Your account is pending verification. Please wait for an administrator to verify your account.');
        }

        return $next($request);
    }
} 