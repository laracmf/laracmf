<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory as View;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class CheckForMaintenanceMode
{
    /**
     * The application instance.
     *
     * @var Application
     */
    protected $app;

    /**
     * The view factory instance.
     *
     * @var View
     */
    protected $view;

    /**
     * Create a new check for maintenance mode instance.
     *
     * @param Application $app
     * @param View $view
     *
     * @return void
     */
    public function __construct(Application $app, View $view)
    {
        $this->app = $app;
        $this->view = $view;
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
        if ($this->app->isDownForMaintenance()) {
            return new Response($this->view->make('maintenance')->render(), 503);
        }

        return $next($request);
    }
}
