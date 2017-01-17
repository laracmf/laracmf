<?php

namespace App\Seeds;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeding.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->truncate();

        $post = [
            'title'      => 'Hello World',
            'summary'    => 'This is the first blog post.',
            'body'       => 'This is an example blog post.',
            'user_id'    => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        DB::table('posts')->insert($post);
    }
}
