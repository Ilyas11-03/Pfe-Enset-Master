<?php

namespace App\Http\Controllers;

use App\Models\FailedLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FailedLoginController extends Controller
{
    public function recordFailedAttempt(Request $request)
    {
        $userId = Auth::id();  
        $ipAddress = $request->ip();

        $failedLogin = FailedLogin::firstOrCreate(
            ['ip_address' => $ipAddress],
            ['login_attempts' => 0, 'last_attempt_at' => now()]
        );

        $failedLogin->increment('login_attempts');
        $failedLogin->last_attempt_at = now();
        $failedLogin->save();

    }

    public function clearFailedAttempts(Request $request)
    {
        $userId = Auth::id();
        $ipAddress = $request->ip();

        FailedLogin::where('ip_address', $ipAddress)->where('user_id', $userId)->delete();
    }
}
