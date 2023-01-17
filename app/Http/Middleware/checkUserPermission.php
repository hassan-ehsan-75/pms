<?php

namespace App\Http\Middleware;

use Closure;

class checkUserPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //not that fancy but works fine
         if( $request->user()->hasPermission('User')   
            //or if the user is an admin
            || $request->user()->hasPermission('Admin')
            //or if the user is a manger
            || $request->user()->hasPermission('Manger'))
            //proced

        return $next($request);
        else
            abort(403);
    }
}
