<?php

namespace App\Tests;

class ViewsControllerTest extends TestCase
{
    /**
     * Test render view registration page
     */
    public function testViewRegisterPage()
    {
        $this->json('GET', 'account/register', [], [])->see('<div class="col-sm-12 col-xs-12 register-buttons">');
    }

    /**
     * Test render view login page
     */
    public function testViewLoginPage()
    {
        $this->json('GET', 'account/login', [], [])->see('><i class="fa fa-rocket"></i> Log In</button>');
    }
}