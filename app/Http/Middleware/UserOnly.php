<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated using web guard
        if (!Auth::guard('web')->check()) {
            return $next($request); // Allow unauthenticated users to access login/register
        }
        
        $user = Auth::guard('web')->user();
        if ($user) {
            // Check if user is admin (user_type = 1) and prevent access
            if ($user->user_type == 1) {
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                return redirect('/admin/login')->withErrors([
                    'email' => 'This area is for regular users only. Admins should use the admin panel.'
                ]);
            }
        }
        
        return $next($request);
    }
}
