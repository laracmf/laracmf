<?php

namespace App\Tests;

use Illuminate\Support\Facades\Mail;

class ResetControllerTest extends TestCase
{
    /**
     * @name providerPostReset
     * @return array
     */
    public function providerPostReset()
    {
        return [
            'testPostReset' => [
                'data' => [
                    'email' => 'admin@dsmg.co.uk',
                ],
                'assertMethod' => 'assertSessionHas',
                'expected' => 'success'
            ],
            'testPostResetFailed' => [
                'data' => [
                    'email' => 'test@dsmg.co.uk',
                ],
                'assertMethod' => 'assertSessionHasErrors',
                'expected' => []
            ],
            'testPostResetFailedSecondCase' => [
                'data' => [
                    'email' => 'admin@',
                ],
                'assertMethod' => 'assertSessionHasErrors',
                'expected' => []
            ]
        ];
    }

    /**
     * Test view reset password page request.
     */
    public function testGetReset()
    {
        $this->json('GET', 'account/reset', [], [])
            ->see('<button class="btn btn-primary" type="submit"><i class="fa fa-rocket"></i> Reset Password</button>');
    }

    /**
     * Test reset flow.
     *
     * @dataProvider providerPostReset
     *
     * @param $data
     * @param $assertMethod
     * @param $expected
     */
    public function testPostReset($data, $assertMethod, $expected)
    {
        Mail::shouldReceive('queue')
            ->andReturn(true);

        $this->json('POST', 'account/reset', $data, [])->{$assertMethod}($expected);
    }
}
