<?php

namespace GrahamCampbell\BootstrapCMS\Services;

use GrahamCampbell\BootstrapCMS\Models\Comment;

/**
 * Class CommentsManagerService
 *
 * @package GrahamCampbell\BootstrapCMS\Services
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
