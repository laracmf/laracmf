<?php

/*
 * This file is part of Bootstrap CMS.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\BootstrapCMS\Seeds;

use Carbon\Carbon;
use GrahamCampbell\Credentials\Facades\Credentials;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * This is the users table seeder class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
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
