<?php

/*
 * This file is part of Bootstrap CMS.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\BootstrapCMS\Http;

use GrahamCampbell\BootstrapCMS\Http\Middleware\AdminMiddleware;
use GrahamCampbell\BootstrapCMS\Http\Middleware\BloggerMiddleware;
use GrahamCampbell\BootstrapCMS\Http\Middleware\EditorMiddleware;
use GrahamCampbell\BootstrapCMS\Http\Middleware\ModeratorMiddleware;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use GrahamCampbell\BootstrapCMS\Http\Middleware\AccessMiddleware;
use GrahamCampbell\BootstrapCMS\Http\Middleware\OwnerMiddleware;

/**
 * This is the http kernel class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var string[]
     */
    protected $middleware = [
        'Fideloper\Proxy\TrustProxies',
        'GrahamCampbell\BootstrapCMS\Http\Middleware\CheckForMaintenanceMode',
        'Illuminate\Cookie\Middleware\EncryptCookies',
        'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
        'Illuminate\Session\Middleware\StartSession',
        'Illuminate\View\Middleware\ShareErrorsFromSession',
        'GrahamCampbell\BootstrapCMS\Http\Middleware\VerifyCsrfToken'
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
        'blogger'       => BloggerMiddleware::class
    ];
}
