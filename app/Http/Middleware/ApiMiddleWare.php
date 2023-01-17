<?php

namespace App\Http\Middleware;

use Closure;

class ApiMiddleWare
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
    

        $token=$request->input('token');
        //check if token is submitted
        if(empty($token))
        {
            return response()->json(['message'=>'no token!!'],200);
        }
        //verify the token
        if(!\App\ApiToken::verifyToken($token))
            {
                return response()->json(['message'=>'bad token!!'],200);
            }
            //added allow for the json headers
            return $next($request)
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');

    }
}