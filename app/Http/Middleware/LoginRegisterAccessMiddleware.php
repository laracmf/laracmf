<?php

namespace App\Http\Middleware;

use Closure;
use GrahamCampbell\Credentials\Credentials;
use Illuminate\Http\Request;

class LoginRegisterAccessMiddleware
{
    /**
     * The credentials instance.
     *
     * @var Credentials
     */
    protected $credentials;

    /**
     * Create a new instance.
     *
     * @param Credentials $credentials
     */
    public function __construct(Credentials $credentials)
    {
        $this->credentials = $credentials;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->credentials->check()) {
            return back();
        }

        return $next($request);
    }
}