<?php

namespace GrahamCampbell\Tests\BootstrapCMS;

use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Mockery;
use stdClass;
use Laravel\Socialite\SocialiteManager;
use GrahamCampbell\BootstrapCMS\Models\User;

class AuthControllerTest extends TestCase
{
    /**
     * @name providerCreateUser
     * @return array
     */
    public function providerCreateUser()
    {
        return [
            'testCreateUser' => [
                'data' => 'test@mail.ru',
                'expected' => 'Redirecting to',
                'message' => 'User has been created.'
            ],
            'testCreateUserSecondCase' => [
                'email' => 'admin@dsmg.co.uk',
                'expected' => 'Redirecting to',
                'message' => 'Found existing user and logged.'
            ]
        ];
    }

    /**
     * @name providerCompleteRegistration
     * @return array
     */
    public function providerCompleteRegistration()
    {
        return [
            'testCompleteRegistration' => [
                'data' => [
                    'password' => 'password',
                    'password_confirmation' => 'password'
                ],
                'id' => 7,
                'expected' => 'Redirecting to'
            ],
            'testCompleteRegistrationSecondCase' => [
                'data' => [
                    'password' => 'password',
                    'password_confirmation' => 'password'
                ],
                'id' => 1,
                'expected' => 'Redirecting to'
            ],
            'testCompleteRegistrationFailed' => [
                'data' => [
                    'password' => 'password',
                    'password_confirmation' => 'paSsasfasfasfasfword'
                ],
                'id' => 7,
                'expected' => 'The password confirmation does not match.'
            ]
        ];
    }

    /**
     * @name providerShowCompleteRegistrationView
     * @return array
     */
    public function providerShowCompleteRegistrationView()
    {
        return [
            'testShowCompleteRegistrationView' => [
                'id' => 0,
                'expected' => 'password_confirmation'
            ],
            'testShowCompleteRegistrationViewFailed' => [
                'id' => 1,
                'expected' => ' Redirecting to'
            ]
        ];
    }

    /**
     * Test create user via socials.
     *
     * @dataProvider providerCreateUser
     *
     * @param string $email
     * @param expected
     * @param $message
     * @return void
     */
    public function testCreateUser($email, $expected, $message)
    {
        $user = new stdClass();

        $user->email = $email;
        $user->name = 'test';

        $socialiteManager = Mockery::mock(SocialiteManager::class);
        $socialiteManager->shouldReceive('user')
            ->andReturn($user);

        Socialite::shouldReceive('driver')
            ->andReturn($socialiteManager);

        Mail::shouldReceive('queue')
            ->andReturn(true);

        $this->json('GET', '/auth/social/github/callback', [], [])->see($expected);

        $user = User::where('email', '=', $email);
        $this->assertNotEmpty($user, $message);
    }

    /**
     * Test complete registration and log user in.
     *
     * @dataProvider providerCompleteRegistration
     *
     * @param $data
     * @param $id
     * @param $expected
     */
    public function testCompleteRegistration($data, $id, $expected)
    {
        $this->createUser();

        $this->json('POST', 'register/complete/' . $id, $data, [])->see($expected);
    }

    /**
     * Test show complete registration view.
     *
     * @dataProvider providerShowCompleteRegistrationView
     *
     * @param $id
     * @param $expected
     */
    public function testShowCompleteRegistrationView($id, $expected)
    {
        $user = $this->createUser();

        $confirmToken = $user->confirm_token;

        if ($id) {
            $confirmToken = 'fake';
        }

        $this->json('GET', 'register/complete/' . $confirmToken, [], [])->see($expected);
    }
}
