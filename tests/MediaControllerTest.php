<?php

namespace App\Tests;

use Mockery;
use App\Services\MediaService;
use App\Models\Media;

class MediaControllerTest extends TestCase
{
    /**
     * @name providerDeleteMedia
     * @return array
     */
    public function providerDeleteMedia()
    {
        return [
            'testDeleteMedia' => [
                'id' => 0,
                'deleteResponse' => true,
                'expected' => 200,
            ],
            'testDeleteMediaFailed' => [
                'id' => 100,
                'deleteResponse' => false,
                'expected' => 403,
            ]
        ];
    }

    /**
     * @var array
     */
    protected $fileData = [
        'type' => 'image/jpeg',
        'name' => 'test.jpg',
        'size' => 10000,
        'path' => 'uploads/php134.jpg'
    ];

    /**
     * Test upload media action.
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testUploadMedia()
    {
        $this->authenticateUser(1);

        $this->fileData['isImage'] = true;

        $mediaService = Mockery::mock('overload:' . MediaService::class);
        $mediaService->shouldReceive('uploadMedia')->once()->andReturn($this->fileData);

        $this->json('POST', 'media', ['files' => 'filedata'], [])->seeJson($this->fileData);
    }

    /**
     * Test delete media action.
     *
     * @dataProvider providerDeleteMedia
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     *
     * @param $id
     * @param $deleteResponse
     * @param $expected
     */
    public function testDeleteMedia($id, $deleteResponse, $expected)
    {
        $this->authenticateUser(1);

        $mediaService = Mockery::mock('overload:' . MediaService::class);
        $mediaService->shouldReceive('deleteMedia')->once()->andReturn($deleteResponse);

        $media = new Media($this->fileData);
        $media->user_id = 2;
        $media->save();

        if (!$id) {
            $id = $media->id;
        }

        $this->json('DELETE', 'media/' . $id, [], [])->assertResponseStatus($expected);
    }
}
