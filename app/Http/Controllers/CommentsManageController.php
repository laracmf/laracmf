<?php

/*
 * This file is part of Bootstrap CMS.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\BootstrapCMS\Http\Controllers;

use GrahamCampbell\BootstrapCMS\Models\Comment;
use GrahamCampbell\BootstrapCMS\Services\CommentsManagerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

/**
 * This is the comment controller class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class CommentsManageController extends AbstractController
{
    const PAGINATE = 5;

    /**
     * Comments manager service instance
     *
     * @var CommentsManagerService
     */
    protected $commentsManagerService;

    public function __construct(CommentsManagerService $commentsManagerService)
    {
        parent::__construct();

        $this->commentsManagerService = $commentsManagerService;
    }

    /**
     * Show all unapproved comments.
     *
     * @return View
     */
    public function showAll()
    {
        return view(
            'manage.comments.index',
            [
                'comments' => Comment::where('approved', '=', false)->paginate(self::PAGINATE)
            ]
        );
    }

    /**
     * Provide multiple actions.
     * Action could be: approve or delete.
     *
     * @param Request $request
     * @param string $action
     * @return \Illuminate\Http\RedirectResponse
     */
    public function multiple($action, Request $request)
    {
        if (method_exists($this->commentsManagerService, $action)) {
            $this->commentsManagerService->{$action}($request->get('comments'));
        }

        return redirect()->back();
    }
}
