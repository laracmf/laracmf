<?php

namespace App\Tests;

use App\Models\Media;
use App\Services\MediaService;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MediaServiceTest extends TestCase
{
    /**
     * Media service instance.
     *
     * @var object
     */
    public $mediaService;

    public function setUp()
    {
        parent::setUp();

        $this->mediaService = new MediaService();

        config(['uploads.upload_dir' => 'public/uploads']);
    }

    /**
     * Test upload files
     */
    public function testUploadMedia()
    {
        $this->authenticateUser(1);

        $uploadedFile = new UploadedFile(
            'resources/assets/test-files/testImage',
            'testImage.png',
            'image/png',
            5007,
            null,
            true
        );

        $this->assertArrayHasKey('path', ($this->mediaService->uploadMedia([$uploadedFile]))[0]);

        copy('public/uploads/testImage.png', 'resources/assets/test-files/testImage');
    }

    /**
     * Test delete media
     */
    public function testDeleteMedia()
    {
        $this->authenticateUser(1);

        $data = [
            'type'    => 'image/png',
            'name'    => 'testImage',
            'size'    => 100,
            'path'    => 'public/uploads/testImage.png'
        ];

        $mediaId = $this->mediaService->saveMedia($data);

        $this->assertTrue($this->mediaService->deleteMedia(Media::find($mediaId)));
    }
}
