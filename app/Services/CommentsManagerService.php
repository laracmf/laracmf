<?php

namespace App\Services;

use App\Models\Comment;

/**
 * Class CommentsManagerService
 *
 * @package App\Services
 */
class CommentsManagerService
{
    /**
     * Approve several rows.
     *
     * @param Comment[] $comments
     */
    public function approve($comments)
    {
        foreach ($comments as $comment) {
            if (is_numeric($comment)) {
                if ($comment = Comment::find($comment)) {
                    $comment->approved = true;
                    $comment->save();
                }
            }
        }
    }

    /**
     * Delete several rows.
     *
     * @param Comment[] $comments
     */
    public function delete($comments)
    {
        foreach ($comments as $comment) {
            if (is_numeric($comment)) {
                if ($comment = Comment::find($comment)) {
                    $comment->delete();
                }
            }
        }
    }
}
