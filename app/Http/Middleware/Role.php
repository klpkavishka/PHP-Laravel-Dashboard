<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $role = null): Response
    {
        // If no role is required or user is not authenticated, proceed
        if (!$role || !$request->user()) {
            return $next($request);
        }

        // Check if the user has the required role using the hasRole method
        if ($request->user()->hasRole($role)) {
            return $next($request);
        }

        // If not authorized, redirect to home or return unauthorized response
        return redirect()->route('home')->with('error', 'Unauthorized access.');
    }
}
