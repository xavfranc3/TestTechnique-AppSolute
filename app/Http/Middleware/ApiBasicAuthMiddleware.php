<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return Auth::onceBasic('user_name') ?: $next($request);
    }
}
