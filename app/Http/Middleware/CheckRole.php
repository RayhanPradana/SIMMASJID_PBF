<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|array  $roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Check if the user is authenticated
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Akses Ditolak'
            ], 401);
        }

        // Allow access if user has one of the specified roles
        if (in_array(auth()->user()->role, $roles)) {
            return $next($request);
        }

        // If user doesn't have one of the specified roles
        return response()->json([
            'success' => false,
            'message' => 'Maaf, anda tidak punya akses'
        ], 403);
    }
}
