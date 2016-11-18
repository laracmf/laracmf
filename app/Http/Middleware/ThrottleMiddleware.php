<?php

namespace GrahamCampbell\BootstrapCMS\Http\Middleware;

use Closure;
use GrahamCampbell\Throttle\Facades\Throttle;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

class ThrottleMiddleware
{
    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Throttle::check($request, 1000000000, 100000)) {
            throw new TooManyRequestsHttpException(60, 'Rate limit exceeded.');
        }

        return $next($request);
    }

}