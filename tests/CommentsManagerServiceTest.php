<?php

namespace App\Tests;

use App\Models\Comment;
use App\Services\CommentsManagerService;

class CommentsManagerServiceTest extends TestCase
{
    /**
     * @var CommentsManagerService
     */
    protected $commentsManagerService;

    public function setUp()
    {
        parent::setUp();

        for ($i = 0; $i < 5; $i++) {
            $this->createComment();
        }

        $this->commentsManagerService = new CommentsManagerService();
    }

    /**
     * Test delete selected comments.
     */
    public function testDelete()
    {
        $comments = Comment::all();
        $commentsCount =  count($comments);

        $this->commentsManagerService->delete($comments->pluck('id')->toArray());

        $comments = Comment::all();

        $this->assertNotEquals($commentsCount, count($comments));
    }

    /**
     * Test approve selected comments.
     */
    public function testApprove()
    {
        $comments = Comment::where('approved', '=', false)->get();
        $commentsCount = count($comments);

        $this->commentsManagerService->approve($comments->pluck('id')->toArray());

        $comments = Comment::where('approved', '=', true)->get();

        $this->assertEquals($commentsCount, count($comments));
    }
}