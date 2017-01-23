<?php

namespace App\Http;

use Fideloper\Proxy\TrustProxies;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\BloggerMiddleware;
use App\Http\Middleware\EditorMiddleware;
use App\Http\Middleware\ModeratorMiddleware;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use App\Http\Middleware\AccessMiddleware;
use App\Http\Middleware\OwnerMiddleware;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Http\Middleware\LoginRegisterAccessMiddleware;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        StartSession::class,
        ShareErrorsFromSession::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            TrustProxies::class,
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            VerifyCsrfToken::class
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
        'json-api' => []
    ];

    /**
     * The application's route middleware.
     *
     * @var string[]
     */
    protected $routeMiddleware = [
        'access'        => AccessMiddleware::class,
        'admin'         => AdminMiddleware::class,
        'moderator'     => ModeratorMiddleware::class,
        'owner'         => OwnerMiddleware::class,
        'editor'        => EditorMiddleware::class,
        'blogger'       => BloggerMiddleware::class,
        'auth'          => Authenticate::class,
        'auth.basic'    => AuthenticateWithBasicAuth::class,
        'bindings'      => SubstituteBindings::class,
        'can'           => Authorize::class,
        'guest'         => RedirectIfAuthenticated::class,
        'throttle'      => ThrottleRequests::class,
        'access.lr'     => LoginRegisterAccessMiddleware::class
    ];
}
