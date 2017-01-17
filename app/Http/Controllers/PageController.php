<?php

namespace App\Http\Controllers;

use Exception;
use GrahamCampbell\Binput\Facades\Binput;
use App\Facades\PageRepository;
use App\Http\Requests\PageRequest;
use App\Models\Page;
use App\Services\GridService;
use App\Services\PagesService;
use GrahamCampbell\Credentials\Facades\Credentials;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PageController extends AbstractController
{
    /**
     * @var PagesService
     */
    protected $pagesService;

    /**
     * @var GridService
     */
    protected $gridService;

    /**
     * Create a new instance.
     *
     * @param PagesService $pagesService
     */
    public function __construct(PagesService $pagesService, GridService $gridService)
    {
        parent::__construct();

        $this->pagesService = $pagesService;
        $this->gridService = $gridService;
    }

    /**
     * Show pages list.
     *
     * @return View
     */
    public function index()
    {
        $pages = Page::all();

        $grid = $this->pagesService->getPagesGrid();

        return view('pages.index', compact('pages', 'links', 'grid'));
    }

    /**
     * Show the form for creating a new page.
     *
     * @return View
     */
    public function create()
    {
        return view('pages.create');
    }

    /**
     * Store a new page.
     *
     * @param PageRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PageRequest $request)
    {
        $input = array_merge($this->getInput(), ['user_id' => Credentials::getuser()->id]);
        $categories = $request->input('categories');

        $val = PageRepository::validate($input, array_keys($input));

        if ($val->fails()) {
            return redirect()->route('pages.create')->withInput()->withErrors($val->errors());
        }

        $page = PageRepository::create($input);

        if ($categories) {
            $this->pagesService->savePageCategories($page, $categories);
        }

        // write flash message and redirect
        return redirect()->route('pages.index')->with('success', trans('messages.page.store_success'));
    }

    /**
     * Show the specified page.
     *
     * @param string $slug
     *
     * @return View
     */
    public function show($slug)
    {
        $page = PageRepository::find($slug);
        $this->checkPage($page, $slug);

        if ($page) {
            $page->categories = $this->pagesService->getPageCategories($page);
        }

        return view('pages.show', ['page' => $page]);
    }

    /**
     * Show the form for editing the specified page.
     *
     * @param string $slug
     *
     * @return View
     */
    public function edit($slug)
    {
        $page = PageRepository::find($slug);

        if ($page) {
            $page->categories = $this->pagesService->getPageCategories($page);
        }

        $this->checkPage($page, $slug);

        return view('pages.edit', ['page' => $page]);
    }

    /**
     * Update an existing page.
     *
     * @param string $slug
     * @param PageRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update($slug, PageRequest $request)
    {
        $input = $this->getInput();
        $categories = $request->input('categories');

        if (empty($input['css'])) {
            $input['css'] = '';
        }

        if (empty($input['js'])) {
            $input['js'] = '';
        }

        $val = PageRepository::validate($input, array_keys($input));

        if ($val->fails()) {
            return redirect()->route('pages.edit', ['pages' => $slug])->withInput()->withErrors($val->errors());
        }

        $page = PageRepository::find($slug);
        $this->checkPage($page, $slug);

        $checkUpdate = $this->checkUpdate($input, $slug);
        if ($checkUpdate) {
            return $checkUpdate;
        }

        $this->pagesService->deletePageCategories($page);

        if (is_array($categories)) {
            $this->pagesService->savePageCategories($page, $categories);
        }

        $page->update($input);

        $page->categories = $this->pagesService->getPageCategories($page);

        // write flash message and redirect
        return redirect()->route('pages.index')->with('success', trans('messages.page.update_success'));
    }

    /**
     * Delete an existing page.
     *
     * @param string $slug
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $page = PageRepository::find($slug);
        $this->checkPage($page, $slug);

        if ($page) {
            $this->pagesService->deletePageCategories($page);
        }

        try {
            $page->delete();
        } catch (Exception $e) {
            // write flash message and redirect
            return  redirect()->route('pages.index')->with('error', trans('messages.page.delete_error'));
        }

        // write flash message and redirect
        return redirect()->route('pages.index')->with('success', trans('messages.page.delete_success'));
    }

    /**
     * Get the user input.
     *
     * @return string[]
     */
    protected function getInput()
    {
        return [
            'title'      => Binput::get('title'),
            'nav_title'  => Binput::get('nav_title'),
            'slug'       => Binput::get('slug'),
            'body'       => Binput::get('body', null, true, false), // no xss protection please
            'css'        => Binput::get('css', null, true, false), // no xss protection please
            'js'         => Binput::get('js', null, true, false), // no xss protection please
            'show_title' => (Binput::get('show_title') == 'on'),
            'show_nav'   => (Binput::get('show_nav') == 'on'),
            'icon'       => Binput::get('icon')
        ];
    }

    /**
     * Check the page model.
     *
     * @param mixed  $page
     * @param string $slug
     *
     * @throws \Exception
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @return void
     */
    protected function checkPage($page, $slug)
    {
        if ($page) {
            return;
        }

        if ($slug == 'home') {
            throw new Exception('The homepage is missing.');
        }

        throw new NotFoundHttpException('Page Not Found');
    }

    /**
     * Check the update input.
     *
     * @param string[] $input
     * @param string   $slug
     *
     * @return \Illuminate\Http\Response
     */
    protected function checkUpdate(array $input, $slug)
    {
        if ($slug == 'home') {
            if ($slug != $input['slug']) {
                return redirect()->route('pages.edit', ['pages' => $slug])->withInput()
                    ->with('error', trans('messages.page.homepage_slug'));
            }

            if ($input['show_nav'] == false) {
                return redirect()->route('pages.edit', ['pages' => $slug])->withInput()
                    ->with('error', trans('messages.page.show_nav'));
            }
        }
    }

    /**
     * Search pages.
     *
     * @return \Illuminate\Http\Response
     */
    protected function searchPages()
    {
        return Page::where('title', 'like', Request::get('query') . '%')->get(['id', 'title as text']);
    }
}
