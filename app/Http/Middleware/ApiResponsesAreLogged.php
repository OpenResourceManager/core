<?php

namespace App\Http\Middleware;

use App\Models\History\Traits\Relationship\HistoryRelationship;
use Closure;

class ApiResponsesAreLogged
{
    use HistoryRelationship;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    public function terminate($request, $response)
    {

    }
}
