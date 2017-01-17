<?php

namespace App\Tests;

use Cartalyst\Sentinel\Permissions\StandardPermissions;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use GrahamCampbell\Credentials\Facades\Credentials;
use Mockery;
use App\Models\Comment;

class TestCase extends \Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    public function setUp()
    {
        parent::setUp();
        DB::beginTransaction();

        $sentinel = Mockery::mock('overload:' . StandardPermissions::class);
        $sentinel->shouldReceive('createPreparedPermissions')->andReturn(
            [
                'user.create' => false,
                'user.delete' => false,
                'user.view' => true,
                'user.update' => true
            ]
        );

        $sentinel->shouldReceive('hasAccess')->andReturn(true);
    }

    public function authenticateUser($id)
    {
        $user = User::find($id);

        if ($user) {
            Credentials::login($user, true);
        }
    }

    /**
     * Create unactivated user method.
     *
     * @return array
     */
    public function createUser()
    {
        $user = new User();

        $user->email = 'test@mail.ru';
        $user->first_name = 'test';
        $user->password = $user->hash(rand(1, 10));

        $user->save();

        $activationResponse = Credentials::getActivationRepository()->create($user);
        $code = $activationResponse ? $activationResponse->code : '';

        return [
            'user' => $user,
            'code' => $code
        ];
    }

    public function createComment()
    {
        $comment = new Comment(
            [
                'body' => 'Test comment.',
                'user_id' =>  1,
                'post_id' => 1
            ]
        );

        $comment->save();
    }

    /**
     * @name tearDown
     */
    public function tearDown()
    {
        DB::rollBack();
    }
}
