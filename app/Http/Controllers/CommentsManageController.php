<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Services\CommentsManagerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

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
