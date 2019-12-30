<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard('web')->check() && !Auth::guard('employee')->check()) {
            // prevent admin from accessing employee login when logged in
            return redirect(RouteServiceProvider::HOME);
        } else if (Auth::guard('employee')->check() && !Auth::guard('web')->check()) {
            // prevent employee from accessing admin login when logged in
            return redirect()->route(config('auth.guards.employee.customRedirect'));
        }


        return $next($request);
    }
}
