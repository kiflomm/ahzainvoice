<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifiedEmployeeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || Auth::user()->role !== 'employee' || !Auth::user()->is_verified) {
            if (Auth::check() && Auth::user()->role === 'employee' && !Auth::user()->is_verified) {
                return redirect()->route('dashboard')->with('error', 'Your account is pending verification by a Super Admin.');
            }

            if (Auth::check() && Auth::user()->role === 'super_admin') {
                return $next($request); // Allow super admins to access everything
            }

            abort(403, 'Unauthorized action. Only verified employees can access this resource.');
        }

        return $next($request);
    }
}
