<?php

/*
 * This file is part of Bootstrap CMS.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * This is the create pages table migration class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class InitMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('title');
            $table->string('nav_title');
            $table->string('slug');
            $table->text('body');
            $table->text('css')->nullable();
            $table->text('js')->nullable();
            $table->boolean('show_title')->default(true);
            $table->boolean('show_nav')->default(true);
            $table->string('icon')->default('');
            $table->integer('user_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('title');
            $table->string('summary');
            $table->text('body');
            $table->integer('user_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->text('body');
            $table->integer('version')->unsigned()->default(1);
            $table->integer('user_id')->unsigned();
            $table->integer('post_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('events', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('title');
            $table->text('body');
            $table->timestamp('date');
            $table->text('location');
            $table->integer('user_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name')->unique()->nullable();
            $table->timestamps();
        });

        Schema::create('categories_pages', function (Blueprint $table) {
            $table->integer('page_id')->unsigned();
            $table->index('page_id');
            $table->foreign('page_id')->references('id')->on('pages');
            $table->integer('category_id')->unsigned();
            $table->index('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('media', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('path')->unique()->nullable();
            $table->string('type');
            $table->index('type');
            $table->integer('size');
            $table->integer('user_id')->unsigned();
            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::drop('pages');
        Schema::drop('posts');
        Schema::drop('comments');
        Schema::drop('events');
        Schema::drop('categories');
        Schema::drop('categories_pages');
        Schema::drop('media');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
