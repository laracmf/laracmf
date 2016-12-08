<?php

namespace GrahamCampbell\Tests\BootstrapCMS;

use GrahamCampbell\BootstrapCMS\Services\CommentsManagerService;
use Mockery;
use GrahamCampbell\BootstrapCMS\Models\Comment;

class CommentsManageControllerTest extends TestCase
{
    /**
     * @name providerMultiple
     * @return array
     */
    public function providerMultiple()
    {
        return [
            'testMultipleDelete' => [
                'action' => 'delete',
                'expected' => '/'
            ],
            'testMultipleFailed' => [
                'action' => 'fakeAction',
                'expected' => '/'
            ]
        ];
    }

    public function setUp()
    {
        parent::setUp();

        $this->authenticateUser(1);

        for ($i = 0; $i < 5; $i++) {
            $this->createComment();
        }
    }

    /**
     * Test show all unapproved comments.
     */
    public function testShowAll()
    {
        $this->json('GET', 'comments', [], [])->see('This is an example comment.');
        $this->json('GET', 'comment/1/approve', [], []);
        $this->json('GET', 'comments', [], [])->dontSee('This is an example comment.');
    }

    /**
     * Test show all unapproved comments.
     *
     * @dataProvider providerMultiple
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     *
     * @param $action
     * @param $expected
     */
    public function testMultiple($action, $expected)
    {
        Mockery::mock('overload:' . CommentsManagerService::class)->shouldReceive('delete')->once()->andReturn(true);

        $comments = Comment::where('approved', '=', false)->get();

        $this->json('POST', 'comments/multiple/' . $action, ['comments' => $comments->pluck('id')->toArray()], [])
            ->assertRedirectedTo($expected);
    }
}
