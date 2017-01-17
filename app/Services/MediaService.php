<?php

namespace App\Services;

use App\Models\Media;
use GrahamCampbell\Credentials\Facades\Credentials;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MediaService
{
    /**
     * Upload media on server.
     *
     * @param UploadedFile[] $files
     * @return array
     */
    public function uploadMedia($files)
    {
        $filesInfo = [];

        foreach ($files as $file) {
            if ($uploadedFile = $this->uploadFile($file)) {
                $filesInfo[] = $uploadedFile;
            }
        }

        return $filesInfo;
    }

    /**
     * Upload file
     *
     * @param UploadedFile $file
     *
     * @return array|bool
     */
    public function uploadFile($file)
    {
        $fileName = $file->getFilename() . '.' . $file->getClientOriginalExtension();
        $type = $file->getClientMimeType();
        $size =  $file->getClientSize();

        if (!$this->checkOnSize($size) && !$this->checkOnType($type)) {
            return false;
        }

        Storage::disk(config('filesystems.default'))->put($fileName, file_get_contents($file->getRealPath()));

        /**
         * @todo: after update to Laravel 5.2 or higher, please use Storage::url instead
         */
        $path = config('uploads.upload_dir') . $fileName;

        $fileData = [
            'type' => $type,
            'name' => $file->getClientOriginalName(),
            'size' => $size,
            'path' => $path
        ];

        if (file_exists($path)) {
            $id = $this->saveMedia($fileData);

            $fileData['id'] = $id;
            $fileData['size'] = formatBytes($size);
            $fileData['deleteUrl'] = route('delete.media', [$id]);
            $fileData['isImage'] = isImage($path);
        }

        return $fileData;
    }

    /**
     * Save media data on server.
     *
     * @param $data
     * @return int
     */
    public function saveMedia($data)
    {
        $media = new Media($data);
        $user = Credentials::getUser();

        if ($user) {
            $media->user_id = $user->id;
        }

        $media->save();

        return $media->id;
    }

    /**
     * Check whether uploaded file size is appropriate.
     *
     * @param int $size
     * @return bool
     */
    public function checkOnSize($size)
    {
        return $size <= config('uploads.size_limit');
    }

    /**
     * Check whether uploaded file type is appropriate.
     *
     * @param string $type
     * @return bool
     */
    public function checkOnType($type)
    {
        return in_array($type, config('uploads.allowed_types'));
    }

    /**
     * Delete media.
     *
     * @param Media $media
     *
     * @return bool
     */
    public function deleteMedia(Media $media)
    {
        if ($media) {
            unlink($media->path);

            return $media->delete();
        }

        return false;
    }
}