<?php

namespace App\Seeds;

use Carbon\Carbon;
use GrahamCampbell\Credentials\Facades\Credentials;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeding.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();

        $user = [
            'first_name'   => 'CMS',
            'last_name'    => 'Admin',
            'email'        => 'admin@dsmg.co.uk',
            'password'     => 'password'
        ];
        Credentials::getUserRepository()->create($user);

        $user = [
            'first_name'   => 'CMS',
            'last_name'    => 'Semi-Admin',
            'email'        => 'semiadmin@dsmg.co.uk',
            'password'     => 'password'
        ];
        Credentials::getUserRepository()->create($user);

        $user = [
            'first_name'   => 'CMS',
            'last_name'    => 'Moderator',
            'email'        => 'moderator@dsmg.co.uk',
            'password'     => 'password'
        ];
        Credentials::getUserRepository()->create($user);

        $user = [
            'first_name'   => 'CMS',
            'last_name'    => 'Blogger',
            'email'        => 'blogger@dsmg.co.uk',
            'password'     => 'password'
        ];
        Credentials::getUserRepository()->create($user);

        $user = [
            'first_name'   => 'CMS',
            'last_name'    => 'Editor',
            'email'        => 'editor@dsmg.co.uk',
            'password'     => 'password'
        ];
        Credentials::getUserRepository()->create($user);

        $user = [
            'first_name'   => 'CMS',
            'last_name'    => 'User',
            'email'        => 'user@dsmg.co.uk',
            'password'     => 'password'
        ];
        Credentials::getUserRepository()->create($user);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
