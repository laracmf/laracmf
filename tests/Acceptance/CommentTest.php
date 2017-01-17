<?php

namespace App\Tests\Acceptance;

use App\Tests\TestCase;

class CommentTest extends TestCase
{
    public function testIndexSuccess()
    {
        $this->authenticateUser(1);
        
        $this->visit('blog/posts/1/comments')->seeJsonEquals(
            [
                [
                    'comment_id' => 1,
                    'comment_ver' => 1
                ]
            ]
        );
    }
}
