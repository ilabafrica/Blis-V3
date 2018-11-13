<?php

namespace App\Http\Middleware;

use Closure;

class specimen
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
        request()->request->add(['request_id' => uniqid()]);
        return $next($request);
    }
}
