<?php

namespace App\Seeds;

use Carbon\Carbon;
use GrahamCampbell\Binput\Facades\Binput;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeding.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('pages')->truncate();

        $home = [
            'title'      => 'Welcome',
            'nav_title'  => 'Home',
            'slug'       => 'home',
            'body'       => $this->getContent('home'),
            'show_title' => false,
            'icon'       => 'home',
            'user_id'    => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        DB::table('pages')->insert($home);

        $contact = [
            'title'      => 'Contact Us',
            'nav_title'  => 'Contact',
            'slug'       => 'contact',
            'body'       => $this->getContent('contact'),
            'user_id'    => 1,
            'icon'       => 'envelope',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        DB::table('pages')->insert($contact);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }

    /**
     * Get the page content.
     *
     * @param string $page
     *
     * @return string
     */
    protected function getContent($page)
    {
        $content = File::get(dirname(__FILE__).'/page-'.$page.'.stub');

        return Binput::clean($content, true, false);
    }
}
