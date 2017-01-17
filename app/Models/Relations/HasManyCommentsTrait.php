<?php

namespace App\Models\Relations;

trait HasManyCommentsTrait
{
    /**
     * Get the comment relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOneOrMany
     */
    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    /**
     * Delete all comments.
     *
     * @return void
     */
    public function deleteComments()
    {
        foreach ($this->comments()->get(['id']) as $comment) {
            $comment->delete();
        }
    }
}
