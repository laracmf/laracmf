<?php
namespace GrahamCampbell\BootstrapCMS\Http\Controllers;

use GrahamCampbell\Credentials\Facades\Credentials;

/**
 * This is the comment controller class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AdminController extends AbstractController
{
    public function index()
    {
        return view('admin.show', ['admin' => Credentials::getUser()]);
    }
}
