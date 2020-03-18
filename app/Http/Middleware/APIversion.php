<?php

namespace App\Http\Middleware;

use Closure;

class APIversion
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param $version
     * @return mixed
     */
    public function handle($request, Closure $next, $version)
    {
//        config(['Setting.API_VERSION' => $version]);
        return $next($request);
    }
}
