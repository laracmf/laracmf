<?php

namespace App\Http\Controllers;

use GrahamCampbell\Credentials\Facades\Credentials;

class AdminController extends AbstractController
{
    public function index()
    {
        return view('admin.show', ['admin' => Credentials::getUser()]);
    }
}
