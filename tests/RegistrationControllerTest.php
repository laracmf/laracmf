<?php

namespace GrahamCampbell\Tests\BootstrapCMS;

use Illuminate\Support\Facades\Mail;

class RegistrationControllerTest extends TestCase
{
    /**
     * @name providerPostRegister
     * @return array
     */
    public function providerPostRegister()
    {
        return [
            'testPostRegister' => [
                'data' => [
                    'email' => 'testing@dsmg.co.uk',
                    'password' => 'password',
                    'password_confirmation' => 'password',
                    'last_name' => 'Test',
                    'first_name' => 'New',
                ],
                'assertMethod' => 'assertSessionHas',
                'expected' => 'success'
            ],
            'testPostRegisterFailed' => [
                'data' => [
                    'email' => 'test@dsmg.co.uk',
                    'password' => 'password'
                ],
                'assertMethod' => 'assertSessionHasErrors',
                'expected' => []
            ],
            'testPostRegisterFailedSecondCase' => [
                'data' => [
                    'email' => 'admin@dsmg.co.uk',
                    'password' => 'password',
                    'password_confirmation' => 'password',
                    'last_name' => 'Test',
                    'first_name' => 'This',
                ],
                'assertMethod' => 'assertSessionHasErrors',
                'expected' => []
            ]
        ];
    }

    /**
     * Test view registration page request.
     */
    public function testGetRegister()
    {
        $this->json('GET', 'account/register', [], [])
            ->see('<button class="btn btn-primary" type="submit"><i class="fa fa-rocket"></i> Register</button>');
    }

    /**
     * Test registration flow.
     *
     * @dataProvider providerPostRegister
     *
     * @param $data
     * @param $assertMethod
     * @param $expected
     */
    public function testPostRegister($data, $assertMethod, $expected)
    {
        Mail::shouldReceive('queue')
            ->andReturn(true);

        $this->json('POST', 'account/register', $data, [])->{$assertMethod}($expected);
    }
}
