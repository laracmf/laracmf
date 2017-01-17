<?php

namespace App\Tests;

class AdminControllerTest extends TestCase
{
    public function testRenderAdminPanel()
    {
        $this->authenticateUser(1);

        $this->json('GET', 'admin', [], [])->see('<a href="' . route('admin.show') . '">');
    }
}
