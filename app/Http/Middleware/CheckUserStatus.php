<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated
        if (! Auth::check()) {
            return redirect('login');
        }

        // Check if the user's status is active
        $user = Auth::user();
        if ($user->status !== 'active') {
            Auth::logout();

            // return redirect('login')->withErrors(['']);
            return redirect()->route('login')->with('error', 'Your account is deactivated. Please contact support.');
        }

        // Check if the user has the role of main_admin or gym_admin or staff
        if (Auth::user()->role !== 'main_admin' && Auth::user()->role !== 'gym_admin' && Auth::user()->role !== 'staff') {
            Auth::logout();

            return redirect()->route('login')->with('error', 'You do not have the required permissions to access this resource.');
        }

        return $next($request);
    }
}
