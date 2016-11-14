<?php

namespace GrahamCampbell\Tests\BootstrapCMS;

use GrahamCampbell\BootstrapCMS\Models\Media;
use GrahamCampbell\BootstrapCMS\Services\MediaService;
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

    public function testUploadMedia()
    {
        $files = [
            new UploadedFile(
                'resources/assets/images/github.png',
                'github.png',
                'image/jpeg',
                5007
            )
        ];

        $this->assertEquals(['dddd'], $this->mediaService->uploadMedia($files));
    }

    public function testDeleteMedia()
    {
        $media = Media::where('name', '=', 'github.png')->first();

        $this->assertTrue($this->mediaService->deleteMedia($media));
    }
}
