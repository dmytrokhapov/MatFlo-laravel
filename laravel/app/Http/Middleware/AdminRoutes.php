<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminRoutes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //admin user type is 2
        if(\Auth::user()->role != 'ADMIN'){
        // if(\Auth::user()->user_type != 2){
            return abort(401);
        }

        return $next($request);
    }
}
