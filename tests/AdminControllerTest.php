<?php

namespace GrahamCampbell\Tests\BootstrapCMS;

class AdminControllerTest extends TestCase
{
    public function testRenderAdminPanel()
    {
        $this->authenticateUser(1);

        $this->json('GET', 'admin', [], [])->see('<li class="active">Dashboard</li>');
    }
}
