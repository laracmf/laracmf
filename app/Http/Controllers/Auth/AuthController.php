<?php

namespace GrahamCampbell\BootstrapCMS\Http\Controllers\Auth;

use GrahamCampbell\BootstrapCMS\Http\Requests\SignUpRequest;
use GrahamCampbell\BootstrapCMS\Models\User;
use GrahamCampbell\BootstrapCMS\Services\MailerService;
use Illuminate\Support\Facades\View;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Response;
use GrahamCampbell\BootstrapCMS\Http\Controllers\AbstractController;
use GrahamCampbell\Credentials\Facades\Credentials;
use GrahamCampbell\BootstrapCMS\Services\SocialUserService;

class AuthController extends AbstractController
{
    /**
     * Mailer service instance
     */
    private $mailerService;

    /**
     * Social user service instance
     */
    private $socialUserService;

    /**
     * AuthController constructor.
     *
     * @param MailerService $mailerService
     * @param SocialUserService $socialUserService
     */
    public function __construct(MailerService $mailerService, SocialUserService $socialUserService)
    {
        parent::__construct();
        $this->mailerService = new $mailerService;
        $this->socialUserService = new SocialUserService();
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

        if ($response) {
            $user = User::where('email', '=', $response->email)->first();

            if ($user) {
                Credentials::login($user);

                return redirect()->route('base');
            }

            $saveUserMethod = 'save' . ucfirst($social) . 'User';

            if (!method_exists($this->socialUserService, $saveUserMethod)) {
                return redirect()->route('base');
            }

            $model = $this->socialUserService->{$saveUserMethod}($response);

            $mail = [
                'url' => route('register.complete', ['confirm_token' =>  $model->confirm_token]),
                'email' => $response->email,
                'subject' => 'Complete your registration',
            ];

            $this->mailerService->sendMessage([
                'template' => 'emails.completeRegistration',
                'email' => $mail['email'],
                'subject' => $mail['subject'],
                'data' => $mail['url']
            ]);
        }

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
        $user = User::where('confirm_token', '=', $token)->get()->first();

        if ($user) {
            return view('auth.registerComplete', ['userId' => $user->id]);
        }

        return view('auth.registerComplete');
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

        if ($user) {
            $user->setAttribute('password', $request->password);
            $user->setAttribute('persist_code', $user->getRandomString());
            $user->activation_code = $user->getRandomString();
            $user->save();

            $user->attemptActivation($user->getActivationCode());
            $user->addGroup(Credentials::getGroupProvider()->findByName('Users'));

            Credentials::login($user);
        }

        return redirect()->route('base');
    }
}
