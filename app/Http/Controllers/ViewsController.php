<?php

namespace GrahamCampbell\BootstrapCMS\Http\Controllers;

class ViewsController extends AbstractController
{
    /**
     * Display the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function getRegister()
    {
        return view('account.register');
    }

    /**
     * Display the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function getLogin()
    {
        return view('account.login');
    }
}