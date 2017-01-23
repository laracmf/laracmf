<?php

namespace App\Http\Controllers;

use App\Models\ThemeUser;
use Illuminate\Http\Request;
use GrahamCampbell\Credentials\Facades\Credentials;

class AdminController extends AbstractController
{
    public function index()
    {
        return view('admin.show', ['admin' => Credentials::getUser()]);
    }

    /**
     * Change theme at admin panel
     *
     * @param Request $request
     */
    public function changeTheme(Request $request)
    {
        $theme = ThemeUser::firstOrCreate(['user_id' => Credentials::getUser()->id]);

        $theme->name = $request->get('theme');
        $theme->save();

        session(['theme' => $theme->name]);
    }
}
