<?php

namespace App\Tests;

use Illuminate\Support\Facades\Mail;

class ActivationControllerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        config(['credentials.activation' => true]);
    }

    /**
     * @name providerGetActivate
     * @return array
     */
    public function providerGetActivate()
    {
        return [
            'testGetActivate' => [
                'userID' => 0,
                'code' => 0,
                'expected' => 'success'
            ],
            'testGetActivateFailed' => [
                'userID' => 0,
                'code' => 'xIrhwUo2TDiZsr5ymHCHLp16xGXmxLYG',
                'expected' => 'error'
            ],
            'testGetActivateFailedSecondCase' => [
                'userID' => 1,
                'code' => 0,
                'expected' => 'error'
            ]
        ];
    }

    /**
     * @name providerPostResend
     * @return array
     */
    public function providerPostResend()
    {
        return [
            'testPostResend' => [
                'assertMethod' => 'assertSessionHas',
                'email' => '',
                'expected' => 'success'
            ],
            'testPostResendInvalidMail' => [
                'assertMethod' => 'assertSessionHasErrors',
                'email' => 'wrongmail',
                'expected' => []
            ],
            'testPostResendAlreadyActivated' => [
                'assertMethod' => 'assertSessionHas',
                'email' => 'admin@dsmg.co.uk',
                'expected' => 'error'
            ],
            'testPostResendFakeMail' => [
                'assertMethod' => 'assertSessionHasErrors',
                'email' => 'fake@dsmg.co.uk',
                'expected' => []
            ]
        ];
    }

    /**
     * Test edit environment.
     *
     * @dataProvider providerGetActivate
     *
     * @param $userID
     * @param $code
     * @param $expected
     */
    public function testGetActivate($userID, $code, $expected)
    {
        $response = $this->createUser();

        if (!$userID) {
            $userID = ($response['user'])->id;
        }

        if (!$code) {
            $code = $response['code'];
        }

        $this->json('GET', 'account/activate/' . $userID . '/' . $code, [], [])->assertSessionHas($expected);
    }

    /**
     * Test show resend form.
     */
    public function testGetResend()
    {
        $this->json('GET', 'account/resend', [], [])->see('<p class="lead">Please enter your details:</p>');
    }

    /**
     * Test resend email flow.
     *
     * @dataProvider providerPostResend
     *
     * @param $assertMethod
     * @param $email
     * @param $expected
     */
    public function testPostResend($assertMethod, $email, $expected)
    {
        Mail::shouldReceive('queue')
            ->andReturn(true);

        if (!$email) {
            $response = $this->createUser();

            $email = ($response['user'])->email;
        }

        $this->json('POST', 'account/resend', ['email' => $email], [])->{$assertMethod}($expected);
    }
}
