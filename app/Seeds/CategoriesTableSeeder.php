<?php

namespace App\Seeds;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeding.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('categories')->truncate();

        DB::table('categories')->insert(
            [
                [
                    'name' => 'blogs'
                ],
                [
                    'name' => 'common'
                ]
            ]
        );

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
