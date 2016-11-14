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
use Webpatser\Uuid\Uuid;
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
                if (!$user->activated) {
                    flash()->warning('User hasn\'t activated!');
                } else {
                    Credentials::login($user);
                }

                return redirect()->route('base');
            }

            $saveUserMethod = 'save' . ucfirst($social) . 'User';

            $model = $this->socialAccountService->{$saveUserMethod}($response, new User());

            $model->password = $model->hash(rand(1, 10));
            $model->confirm_token = Uuid::generate(4);

            $model->save();

            $mail = [
                'url'     => route('register.complete', ['confirm_token' =>  $model->confirm_token]),
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
     * @param string $token
     * @return View
     */
    public function showCompleteRegistrationView($token)
    {
        $user = User::where('confirm_token', '=', $token)->first();

        if ($user && $user->confirm_token) {
            return view('auth.registerComplete', ['userId' => $user->id]);
        }

        flash()->warning('Token invalid!');

        return redirect()->route('base');
    }

    /**
     * Complete registration via socials
     *
     * @param SignUpRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function completeRegistration(SignUpRequest $request, $id)
    {
        $user = User::find($id);

        $flash = [
            'message' => 'User doesn\'t exist!',
            'level' => 'error'
        ];

        if ($user) {
            if (!$user->activated) {
                $user->setAttribute('password', $request->password);
                $user->setAttribute('persist_code', $user->getRandomString());
                $user->activation_code = $user->getRandomString();
                $user->confirm_token = null;

                $user->save();

                $user->attemptActivation($user->getActivationCode());
                $user->addGroup(Credentials::getGroupProvider()->findByName('Users'));

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
