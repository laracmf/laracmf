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

use GrahamCampbell\Credentials\Facades\Credentials;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * This is the groups table seeder class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeding.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->truncate();

        $this->createRole(
            'moderator',
            [
                'user.create' => false,
                'user.delete' => false,
                'user.view'   => true,
                'user.update' => true
            ]
        );

        $this->createRole(
            'blogger',
            [
                'user.create' => false,
                'user.delete' => false,
                'user.view'   => true,
                'user.update' => true
            ]
        );

        $this->createRole(
            'editor',
            [
                'user.create' => false,
                'user.delete' => false,
                'user.view'   => true,
                'user.update' => true
            ]
        );

        $this->createRole(
            'user',
            [
                'user.create' => false,
                'user.delete' => false,
                'user.view'   => true,
                'user.update' => true
            ]
        );

        $this->createRole(
            'admin',
            [
                'user.create' => true,
                'user.delete' => true,
                'user.view'   => true,
                'user.update' => true
            ]
        );
    }

    /**
     * Create new role.
     *
     * @param string $name
     * @param string $permissions
     *
     * @return void
     */
    protected function createRole($name, $permissions)
    {
        $role = Credentials::getRoleRepository()->createModel()->create(
            [
                'name' => ucfirst($name),
                'slug' => $name,
            ]
        );

        $role->permissions = $permissions;

        $role->save();
    }
}
