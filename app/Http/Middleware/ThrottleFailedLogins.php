<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\FailedLogin;
use Illuminate\Http\Request;
use Carbon\Carbon; // Make sure to import Carbon for date manipulation
use Symfony\Component\HttpFoundation\Response;

class ThrottleFailedLogins
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $ipAddress = $request->ip();
        $failedLogin = FailedLogin::where('ip_address', $ipAddress)->first();

        if ($failedLogin) {
            // Check if the last attempt was more than 2 hours ago
            if ($failedLogin->last_attempt_at && Carbon::parse($failedLogin->last_attempt_at)->addHours(2)->isPast()) {
                // Reset the counter
                $failedLogin->update(['login_attempts' => 0, 'last_attempt_at' => now()]);
            } elseif ($failedLogin->login_attempts > 5) {
                // If attempts exceed the limit and 2 hours have not passed, block the login
                return redirect()->route('login')->with('error', 'Too many login attempts. Please try again later.');
            }
        }

        return $next($request);
    }
}
