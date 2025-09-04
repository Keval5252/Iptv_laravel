<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check() && $request->path() !== ltrim(RouteServiceProvider::HOME, '/')) {
                Log::info('RedirectIfAuthenticated triggered', [
                    'guard' => $guard,
                    'user' => Auth::guard($guard)->user(),
                    'path' => $request->path(),
                ]);
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
