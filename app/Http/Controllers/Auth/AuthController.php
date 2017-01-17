<?php

namespace GrahamCampbell\BootstrapCMS\Http\Controllers\Auth;

use GrahamCampbell\BootstrapCMS\Http\Requests\SignUpRequest;
use GrahamCampbell\BootstrapCMS\Models\User;
use Illuminate\Support\Facades\View;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Response;
use GrahamCampbell\BootstrapCMS\Http\Controllers\AbstractController;
use GrahamCampbell\Credentials\Facades\Credentials;
use GrahamCampbell\BootstrapCMS\Services\SocialAccountService;
use Illuminate\Support\Facades\Mail;

class AuthController extends AbstractController
{
    /**
     * Social user service instance
     */
    private $socialAccountService;

    /**
     * AuthController constructor.
     *
     * @param SocialAccountService $socialAccountService
     */
    public function __construct(SocialAccountService $socialAccountService)
    {
        parent::__construct();
        $this->socialAccountService = $socialAccountService;
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @param string $social
     * @return Response
     */
    public function redirectToProvider($social)
    {
        return Socialite::driver($social)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @param string $social
     * @return Response
     */
    public function handleProviderCallback($social)
    {
        $response = Socialite::driver($social)->user();

        $flash = [
            'message' => 'Bad credentials!',
            'level' => 'error'
        ];

        if ($response) {
            $user = User::where('email', '=', $response->email)->first();

            if ($user) {
                if (!Credentials::getActivationRepository()->completed($user)) {
                    flash()->warning('User hasn\'t activated!');
                } else {
                    Credentials::login($user);
                }

                return redirect()->route('base');
            }

            $saveUserMethod = 'save' . ucfirst($social) . 'User';
            $model = $this->socialAccountService->{$saveUserMethod}($response, new User());

            $model->password = $model->hash(rand(1, 10));
            $model->save();

            $activationResponse = Credentials::getActivationRepository()->create($model);
            $code = $activationResponse ? $activationResponse->code : '';

            //Set role for user
            $role = Credentials::getRoleRepository()->findByName('user');
            $role->users()->attach($model);

            $mail = [
                'url'     => route('register.complete', ['id' => $model->id, 'confirm_token' =>  $code]),
                'email'   => $response->email,
                'subject' => 'Complete your registration'
            ];

            Mail::queue('emails.completeRegistration', $mail, function ($message) use ($mail) {
                $message->to($mail['email'])->subject($mail['subject']);
            });

            $flash = [
                'message' => 'Account has successfully created. To complete your registration check the mail ' .
                    $model->email,
                'level' => 'success'
            ];
        }

        flash()->{$flash['level']}($flash['message']);

        return redirect()->route('base');
    }

    /**
     * Show complete registration view
     *
     * @param int $id
     * @param string $code
     * @return View
     */
    public function showCompleteRegistrationView($id, $code)
    {
        $user = User::find($id);

        if ($user) {
            $activation = Credentials::getActivationRepository()->exists($user);

            if ($activation && ($activation->code === $code)) {
                return view('auth.registerComplete', ['userId' => $user->id, 'code' => $code]);
            }
        }

        flash()->warning('Token invalid!');

        return redirect()->route('base');
    }

    /**
     * Complete registration via socials
     *
     * @param SignUpRequest $request
     * @param int $id
     * @param string $code
     * @return \Illuminate\Http\Response
     */
    public function completeRegistration(SignUpRequest $request, $id, $code)
    {
        $user = User::find($id);

        $flash = [
            'message' => 'User doesn\'t exist!',
            'level' => 'error'
        ];

        if ($user) {
            if (!Credentials::getActivationRepository()->completed($user)) {
                $user->setAttribute('password', $user->hash($request->password));
                $user->save();

                Credentials::getActivationRepository()->complete($user, $code);

                Credentials::login($user);

                $flash = [
                    'message' => 'User activated!',
                    'level' => 'success'
                ];
            } else {
                $flash = [
                    'message' => 'User already activated!',
                    'level' => 'warning'
                ];
            }
        }

        flash()->{$flash['level']}($flash['message']);

        return redirect()->route('base');
    }
}
