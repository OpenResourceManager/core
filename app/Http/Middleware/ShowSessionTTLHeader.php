<?php

namespace App\Http\Middleware;

use Closure;

class ShowSessionTTLHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->header('x-jwt-ttl', config('jwt.ttl'));
        return $response;
    }
}
