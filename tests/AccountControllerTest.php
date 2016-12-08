<?php

namespace GrahamCampbell\Tests\BootstrapCMS;

use Illuminate\Support\Facades\Mail;

class AccountControllerTest extends TestCase
{
    /**
     * @name providerGetProfile
     * @return array
     */
    public function providerGetProfile()
    {
        return [
            'testGetProfile' => [
                'userID' => 1,
                'expected' => '<li class="active">Profile</li>'
            ],
            'testGetProfileFailed' => [
                'userID' => 0,
                'expected' => 'Redirecting to'
            ]
        ];
    }

    /**
     * @name providerDeleteProfile
     * @return array
     */
    public function providerDeleteProfile()
    {
        return [
            'testDeleteProfile' => [
                'userID' => 2,
                'expected' => 'success'
            ],
            'testDeleteProfileFailed' => [
                'userID' => 0,
                'expected' => 'error'
            ]
        ];
    }

    /**
     * @name providerPatchPassword
     * @return array
     */
    public function providerPatchPassword()
    {
        return [
            'testPatchPassword' => [
                'data' => [
                    'password' => 'password',
                    'password_confirmation' => 'password'
                ],
                'assertMethod' => 'assertSessionHas',
                'expected' => 'success'
            ],
            'testPatchPasswordFailed' => [
                'data' => [
                    'password' => 'pass',
                    'password_confirmation' => 'pass'
                ],
                'assertMethod' => 'assertSessionHasErrors',
                'expected' => []
            ],
            'testPatchPasswordFailedSecondCase' => [
                'data' => [
                    'password' => 'password',
                    'password_confirmation' => 'passwort'
                ],
                'assertMethod' => 'assertSessionHasErrors',
                'expected' => []
            ]
        ];
    }

    /**
     * @name providerPatchDetails
     * @return array
     */
    public function providerPatchDetails()
    {
        return [
            'testPatchDetailsFailedSecondCase' => [
                'userID' => 0,
                'data' => [
                    'first_name' => 'Bill',
                    'last_name' => 'Gates',
                    'email' => 'email@mail.ru'
                ],
                'assertMethod' => 'assertRedirectedTo',
                'expected' => 'account/login'
            ],
            'testPatchDetails' => [
                'userID' => 2,
                'data' => [
                    'first_name' => 'Alex',
                    'last_name' => 'Maxwell',
                    'email' => 'email@mail.ru'
                ],
                'assertMethod' => 'assertSessionHas',
                'expected' => 'success'
            ],
            'testPatchDetailsFailed' => [
                'userID' => 2,
                'data' => [
                    'first_name' => 'Bill',
                    'last_name' => 'Gates',
                    'email' => 'email'
                ],
                'assertMethod' => 'assertSessionHasErrors',
                'expected' => []
            ]
        ];
    }

    /**
     * Test get user profile.
     *
     * @dataProvider providerGetProfile
     *
     * @param int $userID
     * @param $expected
     */
    public function testGetProfile($userID, $expected)
    {
        $this->authenticateUser($userID);

        $this->json('GET', 'account/profile', [], [])->see($expected);
    }

    /**
     * Test get user profile.
     *
     * @dataProvider providerDeleteProfile
     *
     * @param int $userID
     * @param $expected
     */
    public function testDeleteProfile($userID, $expected)
    {
        $this->authenticateUser($userID);

        Mail::shouldReceive('queue')
            ->andReturn(true);

        $this->json('DELETE', 'account/profile', [], [])->assertSessionHas($expected);
    }

    /**
     * Test get user profile.
     *
     * @dataProvider providerPatchPassword
     *
     * @param array $data
     * @param $assertMethod
     * @param $expected
     */
    public function testPatchPassword($data, $assertMethod, $expected)
    {
        $this->authenticateUser(2);

        Mail::shouldReceive('queue')
            ->andReturn(true);

        $this->json('PATCH', 'account/password', $data, [])->{$assertMethod}($expected);
    }

    /**
     * Test update user details.
     *
     * @dataProvider providerPatchDetails
     *
     * @param int $userID
     * @param array $data
     * @param $assertMethod
     * @param $expected
     */
    public function testPatchDetails($userID, $data, $assertMethod, $expected)
    {
        $this->authenticateUser($userID);

        $this->json('PATCH', 'account/details', $data, [])->{$assertMethod}($expected);
    }
}
