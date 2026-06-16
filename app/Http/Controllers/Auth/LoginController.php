<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FailedLoginController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/login';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        // Validate the login request
        $this->validateLogin($request);

        // Attempt to log the user in
        if (Auth::attempt($request->only('email', 'password'))) {
            // Successful login: clear any failed login records for this user and IP
            app(FailedLoginController::class)->clearFailedAttempts($request);

            // Update last_login timestamp
            $user = User::find(Auth::id());
            $user->update(['last_login' => now()]);

            // Redirect based on role
            return redirect()->intended($this->redirectPath($user));
        }

        // Failed login attempt: record it
        app(FailedLoginController::class)->recordFailedAttempt($request);

        // Return error response or redirect back with errors
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    protected function redirectPath(User $user)
    {
        // Define role-based redirect paths
        $redirectPaths = [
            'main_admin' => '/main_admin/dashboard',
            'gym_admin' => '/gym_admin/dashboard',
            'staff' => '/staff/dashboard',
        ];

        // Return the appropriate path based on the user's role, or default to '/'
        return $redirectPaths[$user->role] ?? '/';
    }

    protected function loggedOut(Request $request)
    {
        // Redirect to a specific route or URL
        return redirect('/login');
    }
}


