<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\GridService;
use GrahamCampbell\Credentials\Http\Controllers\UserController as BaseController;
use Illuminate\Support\Facades\View;
use GrahamCampbell\Credentials\Services\UsersService;
use Nayjest\Grids\ObjectDataRow;

class UserController extends BaseController
{
    /**
     * @var GridService
     */
    protected $gridService;

    /**
     * UserController constructor.
     *
     * @param UsersService $usersService
     * @param GridService $gridService
     */
    public function __construct(UsersService $usersService, GridService $gridService)
    {
        parent::__construct($usersService);

        $this->gridService = $gridService;
    }

    /**
     * Display a listing of the users.
     *
     * @return View
     */
    public function index()
    {
        $users = User::all();

        $callback = function ($val, ObjectDataRow $row) {
            if ($val) {
                return view('partials.usersOptions', ['user' =>  $row->getSrc()]);
            }
        };

        if ($users) {
            $users = $users->filter(function ($user) {
                return !$user->inRole('admin') && !$user->deleted_at;
            });
        }

        $grid = $this->gridService->generateGrid(
            new User(),
            [
                'first_name' => [
                    'filter' => 'like'
                ],
                'last_name' => [
                    'filter' => 'like'
                ],
                'email' => [
                    'filter' => 'like'
                ],
                'id' => [
                    'label' => 'Options',
                    'callback' => $callback,
                    'sortable' => false
                ]
            ]
        );

        return view('users.index', compact('users', 'grid'));
    }
}