<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (! in_array(Auth::user()->role, $roles)) {
            return redirect()->route('login')->with('error', 'Unauthorized access');
        }

        return $next($request);
    }
}
