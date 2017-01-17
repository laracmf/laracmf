<?php

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeding.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $this->call('App\Seeds\UsersTableSeeder');
        $this->call('App\Seeds\RolesTableSeeder');
        $this->call('App\Seeds\UsersRolesTableSeeder');

        $this->call('App\Seeds\PagesTableSeeder');
        $this->call('App\Seeds\PostsTableSeeder');
        $this->call('App\Seeds\CommentsTableSeeder');
        $this->call('App\Seeds\EventsTableSeeder');
        $this->call('App\Seeds\CategoriesTableSeeder');
        $this->call('App\Seeds\CategoriesPagesTableSeeder');
    }
}
