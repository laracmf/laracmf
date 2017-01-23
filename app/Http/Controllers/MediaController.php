<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use App\Services\MediaService;
use Illuminate\View\View;
use Illuminate\Contracts\View\Factory as FactoryView;
use Illuminate\Contracts\Routing\ResponseFactory;
use Symfony\Component\HttpFoundation\Response;

class MediaController extends AbstractController
{
    const PAGINATE = 16;

    /**
     * @var MediaService
     */
    protected $mediaService;

    /**
     * MediaController constructor.
     *
     * @param MediaService $mediaService
     */
    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;

        parent::__construct();
    }

    /**
     * Upload media files on server
     *
     * @param Request $request
     *
     * @return array
     */
    public function uploadMedia(Request $request)
    {
        $data = $request->all();

        return $this->mediaService->uploadMedia($data['files']);
    }

    /**
     * Show all media files.
     *
     * @return FactoryView|View
     */
    public function showAllMedia()
    {
        $media = Media::all();

        $grid = $this->mediaService->generateGrid();

        return view('media.show', compact('media', 'links', 'grid'));
    }

    /**
     * Delete media file from server.
     *
     * @param $id
     *
     * @return ResponseFactory|int|Response
     */
    public function deleteMedia($id)
    {
        $media = Media::find($id);

        if ($this->mediaService->deleteMedia($media)) {
            flash()->success('Media was deleted!');

            return $this->response(true);
        }

        flash()->error('Media doesn\'t exist.');

        return $this->response(false);
    }
}