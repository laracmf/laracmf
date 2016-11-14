<?php

namespace GrahamCampbell\Tests\BootstrapCMS;

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
    }

//    public function testUploadMedia()
//    {
//        $files = [
//            new UploadedFile(
//                '/tmp/php0abON1',
//                'images.jpg',
//                'mimeType',
//                5007
//            )
//        ];
//
//        $this->assertEquals(['dddd'], $this->mediaService->uploadMedia($files));
//    }
//
//    public function testUploadMedia()
//    {
//        $files = [
//            new UploadedFile(
//                '/tmp/php0abON1',
//                'images.jpg',
//                'mimeType',
//                5007
//            )
//        ];
//
//        $this->assertEquals(['dddd'], $this->mediaService->uploadMedia($files));
//    }
}
