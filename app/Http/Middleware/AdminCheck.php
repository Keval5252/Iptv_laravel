<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;



class AdminCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated using admin guard
        if (!Auth::guard('admin')->check()) {
            return redirect("/admin/login");
        }
        
    $user = Auth::guard('admin')->user();
    // Make the 'admin' guard the default for the current request so
    // calls to Auth::user() or auth()->user() resolve to the admin user.
    Auth::shouldUse('admin');
        if ($user) {
            // Check if user is admin (user_type = 1)
            if ($user->user_type != 1) {
                Auth::guard('admin')->logout();
                return redirect("/admin/login")->withErrors(['email' => 'Access denied. Admin privileges required.']);
            }
        }
        
        return $next($request);
    }
}
