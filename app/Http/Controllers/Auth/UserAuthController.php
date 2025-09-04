<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserAuthController extends Controller
{
    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.user-login');
    }

    public function showRegistrationForm()
    {
        return view('auth.user-register');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Use web guard specifically for user authentication
        if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            $user = Auth::guard('web')->user();
            
            // Check if user has admin role and prevent login
            if ($user->hasRole('admin') || $user->hasRole('super-admin')) {
                Auth::guard('web')->logout();
                return back()->withErrors([
                    'email' => 'This login is for regular users only. Admins should use the admin login.',
                ])->withInput($request->only('email'));
            }
            
            
            // Regenerate session to prevent session fixation
            $request->session()->regenerate();
            
            if ($user->hasActiveSubscription()) {
                return redirect()->intended(route('subscription.dashboard'));
            } else {
                return redirect()->intended(route('subscription.plans'));
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'user_name' => 'required|string|max:255|unique:users|regex:/^[a-zA-Z0-9._-]+$/',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'user_name' => $request->user_name,
            'user_type' => 2, // 2 = Regular User (1 = Admin)
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'postal_code' => $request->postal_code,
            'gender' => 1, // Default to male (1)
            'is_notification' => 1, // Default to enabled (1)
            'status' => 1, // Default to active (1)
        ]);

        // Use web guard specifically for user authentication
        Auth::guard('web')->login($user);

        return redirect('/subscription-plans');
    }

    public function logout(Request $request)
    {
        // Use web guard specifically for user logout
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}
