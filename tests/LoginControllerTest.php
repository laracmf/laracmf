<?php

namespace GrahamCampbell\Tests\BootstrapCMS;

use GrahamCampbell\Credentials\Facades\Credentials;

class LoginControllerTest extends TestCase
{
    /**
     * @name providerPostLogin
     * @return array
     */
    public function providerPostLogin()
    {
        return [
            'testPostLogin' => [
                'data' => [
                    'rememberMe' => 1,
                    'email' => 'admin@dsmg.co.uk',
                    'password' => 'password'
                ],
                'assertMethod' => 'assertRedirectedTo',
                'expected' => 'pages/home'
            ],
            'testPostLoginFailed' => [
                'data' => [
                    'rememberMe' => 0,
                    'email' => 'admin',
                    'password' => 'password'
                ],
                'assertMethod' => 'assertSessionHasErrors',
                'expected' => []
            ],
            'testPostLoginFailedSecondCase' => [
                'data' => [
                    'rememberMe' => 0,
                    'email' => 'fake@dsmg.co.uk',
                    'password' => 'password'
                ],
                'assertMethod' => 'assertSessionHasErrors',
                'expected' => []
            ]
        ];
    }

    /**
     * Test view login page request.
     */
    public function testGetLogin()
    {
        $this->json('GET', 'account/login', [], [])
            ->see('<form class="form-horizontal" action="' . route('account.login') . '" method="POST">');
    }

    /**
     * Test login flow.
     *
     * @dataProvider providerPostLogin
     *
     * @param $data
     * @param $assertMethod
     * @param $expected
     */
    public function testPostLogin($data, $assertMethod, $expected)
    {
        $this->json('POST', 'account/login', $data, [])->{$assertMethod}($expected);
    }

    /**
     * Test logout flow.
     */
    public function testLogout()
    {
        $this->authenticateUser(1);

        $this->assertNotEmpty(Credentials::getUser());

        $this->json('GET', 'account/logout', [], [])->assertRedirectedTo('pages/home');

        $this->assertEmpty(Credentials::getUser());
    }
}
