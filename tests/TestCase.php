<?php

namespace GrahamCampbell\Tests\BootstrapCMS;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;
use GrahamCampbell\BootstrapCMS\Models\User;
use GrahamCampbell\Credentials\Facades\Credentials;
use Webpatser\Uuid\Uuid;

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
    }

    public function authenticateUser($id)
    {
        $user = User::find($id);
        Credentials::login($user, true);
    }

    /**
     * Create unactivated user method.
     *
     * @return User
     */
    public function createUser()
    {
        $user = new User();

        $user->email = 'test@mail.ru';
        $user->first_name = 'test';
        $user->password = $user->hash(rand(1, 10));
        $user->confirm_token = Uuid::generate(4);

        $user->save();

        return $user;
    }

    /**
     * @name tearDown
     */
    public function tearDown()
    {
        DB::rollBack();
    }
}
