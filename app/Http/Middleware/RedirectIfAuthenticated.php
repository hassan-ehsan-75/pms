<?php

namespace App\Http\Middleware;

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
    public function handle($request, Closure $next, $guard )
    {

        if (Auth::guard($guard)->check()) {
            return redirect('/dashboard');
            return new RedirectResponse(url('/dashboard'));
        }
        if(!Auth::check())
            return redirect('/login-form');
            else
                return redirect('/dashboard');
        return $next($request);

    }
}
