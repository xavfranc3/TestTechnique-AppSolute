<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiBasicAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->getUser() === env('BASIC_AUTH_USERNAME') && $request->getPassword() === env('BASIC_AUTH_PASSWORD'))
        {
            return $next($request);
        } else
        {
            return response() ->json('Unauthorized access', 401);
        }
    }
}
