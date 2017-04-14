<?php

namespace App\Http\Controllers;

use GrahamCampbell\Binput\Facades\Binput;
use App\Facades\PostRepository;
use GrahamCampbell\Credentials\Facades\Credentials;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Services\PostService;

class PostController extends AbstractController
{
    /**
     * @var PostService
     */
    protected $postService;

    /**
     * PostController constructor.
     * @param PostService $postService
     */
    public function __construct(PostService $postService)
    {
        parent::__construct();

        $this->postService = $postService;
    }

    /**
     * Display a listing of the posts.
     *
     * @return View
     */
    public function index()
    {
        $posts = PostRepository::paginate();
        $links = PostRepository::links();

        return view('posts.index', ['posts' => $posts, 'links' => $links]);
    }

    /**
     * Show the form for creating a new post.
     *
     * @return View
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a new post.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $input = array_merge(['user_id' => Credentials::getuser()->id], Binput::only([
            'title', 'summary', 'body',
        ]));

        $val = PostRepository::validate($input, array_keys($input));
        if ($val->fails()) {
            return redirect()->route('posts.create')->withInput()->withErrors($val->errors());
        }

        $post = PostRepository::create($input);

        return redirect()->route('posts.show', ['posts' => $post->id])
            ->with('success', trans('messages.post.store_success'));
    }

    /**
     * Show the specified post.
     *
     * @param int $id
     *
     * @return View
     */
    public function show($id)
    {
        $post = PostRepository::find($id);
        $this->postService->checkPost($post);

        $comments = $post->comments()->orderBy('id', 'desc')->get();

        return view('posts.show', ['post' => $post, 'comments' => $comments]);
    }

    /**
     * Show the form for editing the specified post.
     *
     * @param int $id
     *
     * @return View
     */
    public function edit($id)
    {
        $post = PostRepository::find($id);
        $this->postService->checkPost($post);

        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update an existing post.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $input = Binput::only(['title', 'summary', 'body']);

        $val = PostRepository::validate($input, array_keys($input));
        if ($val->fails()) {
            return redirect()->route('posts.edit', ['posts' => $id])->withInput()->withErrors($val->errors());
        }

        $post = PostRepository::find($id);
        $this->postService->checkPost($post);

        $post->update($input);

        return redirect()->route('posts.show', ['posts' => $post->id])
            ->with('success', trans('messages.post.update_success'));
    }

    /**
     * Delete an existing post.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = PostRepository::find($id);
        $this->postService->checkPost($post);

        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', trans('messages.post.delete_success'));
    }
}
