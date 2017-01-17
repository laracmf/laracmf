<?php

namespace App\Tests\Functional;

use App\Tests\AbstractTestCase;
use Illuminate\Contracts\Console\Kernel;

class CommandTest extends AbstractTestCase
{
    public function testInstall()
    {
        $this->assertSame(0, $this->app->make(Kernel::class)->call('app:install'));
    }
    public function testReset()
    {
        $this->assertSame(0, $this->app->make(Kernel::class)->call('migrate', ['--force' => true]));
        $this->assertSame(0, $this->app->make(Kernel::class)->call('app:reset'));
    }
    public function testUpdate()
    {
        $this->assertSame(0, $this->app->make(Kernel::class)->call('app:update'));
    }
    public function testResetAfterInstall()
    {
        $this->assertSame(0, $this->app->make(Kernel::class)->call('app:install'));
        $this->assertSame(0, $this->app->make(Kernel::class)->call('app:reset'));
    }
}