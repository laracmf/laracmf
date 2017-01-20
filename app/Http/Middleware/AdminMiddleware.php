<?php

namespace App\Http\Middleware;

use App\Models\ThemeUser;
use Closure;
use GrahamCampbell\Credentials\Credentials;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AdminMiddleware
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
     * @param Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!session('theme') && $user = $this->credentials->getUser()) {
            $theme = ThemeUser::where('user_id', $user->id)->first();

            session(['theme' => $theme ? $theme->name : 'skin-blue']);
        }

        if ($this->credentials->inRole('admin')) {
            return $next($request);
        }

        return Redirect::guest(route('base'))
            ->with('error', 'You must have admin permissions.');
    }
}