<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $roles)
    {
        
        if (!Auth::check()) {
            return redirect()->route('login'); // not logged in
        }

        $allowed = array_map('trim', explode('|', $roles));

        if (in_array(Auth::user()->role, $allowed, true)) {
            return $next($request);
        }

        abort(403, 'Unauthorized.');
    }
}