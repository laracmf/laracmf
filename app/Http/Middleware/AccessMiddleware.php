<?php

namespace App\Http\Middleware;

use Closure;
use GrahamCampbell\Credentials\Credentials;
use Illuminate\Support\Facades\Redirect;
use Psr\Log\LoggerInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AccessMiddleware
{
    /**
     * The credentials instance.
     *
     * @var Credentials
     */
    protected $credentials;

    /**
     * The logger instance.
     *
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Create a new instance.
     *
     * @param Credentials $credentials
     * @param LoggerInterface $logger
     */
    public function __construct(Credentials $credentials, LoggerInterface $logger)
    {
        $this->credentials = $credentials;
        $this->logger = $logger;
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
        if (!$this->credentials->check()) {
            $this->logger->info('User tried to access a page without being logged in', ['path' => $request->path()]);
            if ($request->ajax()) {
                throw new UnauthorizedHttpException('Action Requires Login');
            }

            return Redirect::guest(route('account.login'))
                ->with('error', 'You must be logged in to perform that action.');
        }

        return $next($request);
    }
}