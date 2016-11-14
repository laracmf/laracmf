<?php

namespace GrahamCampbell\Tests\BootstrapCMS;

class ViewsControllerTest extends TestCase
{
    /**
     * Test render view registration page
     */
    public function testViewRegisterPage()
    {
        $this->json('GET', 'account/register', [], [])->see('<li class="active">Registration</li>');
    }

    /**
     * Test render view login page
     */
    public function testViewLoginPage()
    {
        $this->json('GET', 'account/login', [], [])->see('<li class="active">Login</li>');
    }
}