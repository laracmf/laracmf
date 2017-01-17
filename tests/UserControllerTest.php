<?php

namespace GrahamCampbell\Tests\BootstrapCMS;

use Illuminate\Support\Facades\Mail;

class UserControllerTest extends TestCase
{
    /**
     * @name providerStore
     * @return array
     */
    public function providerStore()
    {
        return [
            'testStore' => [
                'data' => [
                    'email' => 'testing@dsmg.co.uk',
                    'last_name' => 'Test',
                    'first_name' => 'New',
                ],
                'assertMethod' => 'assertSessionHas',
                'expected' => 'success'
            ],
            'testStoreFailed' => [
                'data' => [
                    'email' => 'admin@dsmg.co.uk',
                    'last_name' => 'Test',
                    'first_name' => 'New',
                ],
                'assertMethod' => 'assertSessionHasErrors',
                'expected' => []
            ],
            'testStoreFailedSecondCase' => [
                'data' => [
                    'email' => 'test@mail.ru',
                    'last_name' => 'T',
                    'first_name' => 'New',
                ],
                'assertMethod' => 'assertSessionHasErrors',
                'expected' => []
            ]
        ];
    }

    /**
     * @name providerUpdate
     * @return array
     */
    public function providerUpdate()
    {
        return [
            'testUpdate' => [
                'userID' => 2,
                'data' => [
                    'email' => 'testing@dsmg.co.uk',
                    'last_name' => 'Test',
                    'first_name' => 'New',
                    'role_1' => 'on',
                    'role_2' => 'on',
                    'role_3' => 'on',
                    'role_4' => 'on'
                ],
                'assertMethod' => 'assertSessionHas',
                'expected' => 'success'
            ],
            'testUpdateFailed' => [
                'userID' => 0,
                'data' => [
                    'email' => 'admin@dsmg.co.uk',
                    'last_name' => 'Test',
                    'first_name' => 'New',
                    'role_1' => 'on',
                    'role_2' => 'on',
                ],
                'assertMethod' => 'see',
                'expected' => '<h1 class="error-text">NOT FOUND</h1>'
            ],
            'testUpdateFailedSecondCase' => [
                'userID' => 2,
                'data' => [
                    'email' => 'test@mail.ru',
                    'last_name' => 'T',
                    'first_name' => 'New',
                    'role_1' => 'on',
                    'role_2' => 'on',
                ],
                'assertMethod' => 'assertSessionHasErrors',
                'expected' => []
            ]
        ];
    }

    /**
     * @name providerResend
     * @return array
     */
    public function providerResend()
    {
        return [
            'testResend' => [
                'userID' => 0,
                'assertMethod' => 'assertSessionHas',
                'expected' => 'success'
            ],
            'testResendFailed' => [
                'userID' => 2,
                'assertMethod' => 'assertSessionHas',
                'expected' => 'error'
            ]
        ];
    }

    /**
     * Test display a listing of the users request.
     */
    public function testIndex()
    {
        $this->authenticateUser(1);

        $this->json('GET', 'users', [], [])
            ->see('<a class="btn btn-danger" href="#delete_user_4" data-toggle="modal" data-target="#delete_user_4">');
    }

    /**
     * Test view form for creating a new user.
     */
    public function testShowCreateUserForm()
    {
        $this->authenticateUser(1);

        $this->json('GET', 'users/create', [], [])
            ->see(
                '<button class="btn btn-primary" type="submit"><i class="fa fa-rocket"></i> Create New User</button>'
            );
    }

    /**
     * Test store new user flow.
     *
     * @dataProvider providerStore
     *
     * @param $data
     * @param $assertMethod
     * @param $expected
     */
    public function testStore($data, $assertMethod, $expected)
    {
        $this->authenticateUser(1);

        Mail::shouldReceive('queue')
            ->andReturn(true);

        $this->json('POST', 'users', $data, [])->{$assertMethod}($expected);
    }

    /**
     * Test show user.
     */
    public function testShow()
    {
        $this->authenticateUser(1);

        $this->json('GET', 'users/2', [], [])
            ->see('Currently showing CMS Semi-Admin\'s profile:');
    }

    /**
     * Test show edit user form.
     */
    public function testEdit()
    {
        $this->authenticateUser(1);

        $this->json('GET', 'users/2/edit', [], [])
            ->see('<button class="btn btn-primary" type="submit"><i class="fa fa-rocket"></i> Save User</button>');
    }

    /**
     * Test show edit user form.
     *
     * @dataProvider providerUpdate
     *
     * @param $userID
     * @param $data
     * @param $assertMethod
     * @param $expected
     */
    public function testUpdate($userID, $data, $assertMethod, $expected)
    {
        $this->authenticateUser(1);

        Mail::shouldReceive('queue')
            ->andReturn(true);

        $this->json('PUT', 'users/' . $userID, $data, [])->{$assertMethod}($expected);
    }

    /**
     * Test reset password.
     */
    public function testReset()
    {
        $this->authenticateUser(1);

        Mail::shouldReceive('queue')
            ->andReturn(true);

        $this->json('POST', 'users/2/reset', [], [])->assertSessionHas('success');
    }

    /**
     * Test resend password.
     *
     * @dataProvider providerResend
     *
     * @param $userID
     * @param $assertMethod
     * @param $expected
     */
    public function testResend($userID, $assertMethod, $expected)
    {
        $this->authenticateUser(1);

        $response = $this->createUser();

        if (!$userID) {
            $userID = ($response['user'])->id;
        }

        Mail::shouldReceive('queue')
            ->andReturn(true);

        $this->json('POST', 'users/' . $userID . '/resend', [], [])->{$assertMethod}($expected);
    }

    /**
     * Test destroy user account.
     */
    public function testDestroy()
    {
        $this->authenticateUser(1);

        $response = $this->createUser();

        Mail::shouldReceive('queue')
            ->andReturn(true);

        $this->json('DELETE', 'users/' . ($response['user'])->id, [], [])->assertSessionHas('success');
    }
}
