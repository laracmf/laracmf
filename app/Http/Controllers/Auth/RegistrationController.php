<?php

namespace GrahamCampbell\BootstrapCMS\Http\Controllers\Auth;

use GrahamCampbell\BootstrapCMS\Http\Requests\SignUpRequest;
use GrahamCampbell\BootstrapCMS\Models\User;
use GrahamCampbell\BootstrapCMS\Services\MailerService;
use Illuminate\Support\Facades\View;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Response;
use GrahamCampbell\BootstrapCMS\Http\Controllers\AbstractController;
use Webpatser\Uuid\Uuid;
use GrahamCampbell\Credentials\Facades\Credentials;

class RegistrationController extends AbstractController
{

    /**
     * Mailer service instance
     */
    private $mailerService;

    /**
     * AuthController constructor.
     *
     * @param MailerService $mailerService
     */
    public function __construct(MailerService $mailerService)
    {
        parent::__construct();
        $this->mailerService = new $mailerService;
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('github')->user();

        $confirm_token = Uuid::generate(4);

        $model = new User();

        $model->email = $user->email;
        $model->first_name = $user->name;
        $model->password = bcrypt(Uuid::generate(4));
        $model->confirm_token = $confirm_token;

        $model->save();

        $mail = [
            'url' => route('register.complete', ['confirm_token' => $confirm_token]),
            'email' => $user->email,
            'subject' => 'Complete your registration',
        ];

        $this->mailerService->sendMessage([
            'template' => 'emails.completeRegistration',
            'email' => $mail['email'],
            'subject' => $mail['subject'],
            'data' => $mail['url']
        ]);


        return $this->response(true, $model);
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
            $user->password = bcrypt($request->password);
            $user->activated = 1;
            $user->save();

            $user->addGroup(Credentials::getGroupProvider()->findByName('Users'));

            return redirect()->route(
                'base',
                [
                    'flash' => true,
                    'message' => 'Account successfully created!',
                    'alert' => 'alert-success'
                ]
            );
        }

        return redirect()->route(
            'base',
            [
                'flash' => true,
                'message' => 'User doesn\'t exist!',
                'alert' => 'alert-danger'
            ]
        );
    }
}
