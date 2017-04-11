<?php

namespace Confee\Units\Core\Http\Middleware;

use Closure;

/**
 * Class AlwaysExpectsJson
 * Add Request Headers Accept Application/Json
 *
 * @package Confee\Units\Core\Http\Middleware
 */
class AlwaysExpectsJson
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
        $request->headers->add(['Accept' => 'application/json']);
        return $next($request);
    }
}