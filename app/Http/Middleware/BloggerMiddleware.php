<?php

namespace App\Http\Middleware;

use Closure;
use GrahamCampbell\Credentials\Credentials;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class BloggerMiddleware
{
    /**
     * The credentials instance.
     *
     * @var \GrahamCampbell\Credentials\Credentials
     */
    protected $credentials;

    /**
     * Create a new instance.
     *
     * @param \GrahamCampbell\Credentials\Credentials $credentials
     */
    public function __construct(Credentials $credentials)
    {
        $this->credentials = $credentials;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->credentials->inRole('blogger') || $this->credentials->inRole('admin')) {
            return $next($request);
        }

        return Redirect::guest(route('base'))
            ->with('error', 'You must have moderator permissions.');
    }
}