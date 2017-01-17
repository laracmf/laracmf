<?php

namespace App\Seeds;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
                ]
            ]
        );

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
