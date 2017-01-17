<?php

namespace App\Tests;

use GrahamCampbell\TestBenchCore\LaravelTrait;
use GrahamCampbell\TestBenchCore\ServiceProviderTrait;

class ServiceProviderTest extends AbstractTestCase
{
    use LaravelTrait, ServiceProviderTrait;

    public function testNavigationFactoryIsInjectable()
    {
        $this->assertIsInjectable('App\Navigation\Factory');
    }

    public function testCommentRepositoryIsInjectable()
    {
        $this->assertIsInjectable('App\Repositories\CommentRepository');
    }

    public function testEventRepositoryIsInjectable()
    {
        $this->assertIsInjectable('App\Repositories\EventRepository');
    }

    public function testPageRepositoryIsInjectable()
    {
        $this->assertIsInjectable('App\Repositories\PageRepository');
    }

    public function testPostRepositoryIsInjectable()
    {
        $this->assertIsInjectable('App\Repositories\PostRepository');
    }
}
