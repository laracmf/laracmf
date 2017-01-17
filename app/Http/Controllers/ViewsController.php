<?php

namespace App\Http\Controllers;

class ViewsController extends AbstractController
{
    /**
     * Display the registration form.
     *
     * @return View
     */
    public function getRegister()
    {
        return view('account.register');
    }

    /**
     * Display the registration form.
     *
     * @return View
     */
    public function getLogin()
    {
        return view('account.login');
    }
}