<?php

namespace App\Tests;

use Illuminate\Contracts\Console\Kernel;

class BasicTest extends TestCase
{
    public function testBase()
    {
        $this->visit('/')->seePageIs('pages/home');
    }

    public function testBlog()
    {
        $this->visit('blog')->seePageIs('blog/posts');
    }
}
