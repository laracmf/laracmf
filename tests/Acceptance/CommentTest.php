<?php

/*
 * This file is part of Bootstrap CMS.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Tests\BootstrapCMS\Acceptance;

use GrahamCampbell\Tests\BootstrapCMS\TestCase;

/**
 * This is the comment test class.
 *
 * @group comment
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
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
