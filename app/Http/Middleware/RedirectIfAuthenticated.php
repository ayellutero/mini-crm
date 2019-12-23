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
        if (Auth::guard($guard)->check()) {
            // \Log::info(RouteServiceProvider::HOME);
            // foreach(config('auth.guards') as $key => $value) {
            //     if ($key === $guard) {
            //     \Log::info($key .':' . $guard . ' => ' . $value['redirectTo']);
            //     return redirect()->route($value['redirectTo']);
            //     }
            // }

            // \Log::info($guard . ' => ' . config('auth.guards.employee.customRedirect'));
            // \Log::info(config('auth.guards')['web']['customRedirect']);

            if (array_key_exists('customRedirect', config('auth.guards.' . $guard))) {
                // dd(config('auth.guards.'.$guard.'customRedirect'));
                return redirect()->route(config('auth.guards.' . $guard . '.customRedirect'));
            }

            // return redirect(RouteServixceProvider::HOME);
        }

        return $next($request);
    }
}
