<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class checkAdminOrMangerPermission
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
        //if admin or manger do what ever you want
        if($request->user()->hasPermission('Admin') || 
                     $request->user()->hasPermission('Manger'))
            return $next($request);
        else
              abort(403,"exception");
    }
}
