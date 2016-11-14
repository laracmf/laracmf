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
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * This is the comments table seeder class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class CategoriesPagesTableSeeder extends Seeder
{
    /**
     * Run the database seeding.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('categories_pages')->truncate();

        DB::table('categories_pages')->insert(
            [
                [
                    'page_id' => 1,
                    'category_id' => 2
                ],
                [
                    'page_id' => 2,
                    'category_id' => 2
                ],
                [
                    'page_id' => 2,
                    'category_id' => 1
                ],
                [
                    'page_id' => 3,
                    'category_id' => 1
                ]
            ]
        );

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
