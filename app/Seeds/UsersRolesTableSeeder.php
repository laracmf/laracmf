<?php

namespace App\Seeds;

use App\Models\User;
use GrahamCampbell\Credentials\Facades\Credentials;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeding.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_users')->truncate();

        $this->matchUser('admin@dsmg.co.uk', 'admin');
        $this->matchUser('semiadmin@dsmg.co.uk', 'moderator');
        $this->matchUser('semiadmin@dsmg.co.uk', 'blogger');
        $this->matchUser('semiadmin@dsmg.co.uk', 'editor');
        $this->matchUser('moderator@dsmg.co.uk', 'moderator');
        $this->matchUser('blogger@dsmg.co.uk', 'blogger');
        $this->matchUser('editor@dsmg.co.uk', 'editor');
        $this->matchUser('user@dsmg.co.uk', 'user');
        $this->matchUser('semiadmin@dsmg.co.uk', 'user');
        $this->matchUser('moderator@dsmg.co.uk', 'user');
        $this->matchUser('blogger@dsmg.co.uk', 'user');
        $this->matchUser('editor@dsmg.co.uk', 'user');
        $this->matchUser('admin@dsmg.co.uk', 'user');
    }

    /**
     * Add the user by email to a group.
     *
     * @param string $email
     * @param string $name
     *
     * @return void
     */
    protected function matchUser($email, $name)
    {
        $role = Credentials::getRoleRepository()->findByName($name);
        $user = User::where('email', '=', $email)->first();

        $activationResponse = Credentials::getActivationRepository()->create($user);
        Credentials::getActivationRepository()->complete($user, $activationResponse->code);

        $role->users()->attach($user);
    }
}
