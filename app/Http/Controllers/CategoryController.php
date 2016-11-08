<?php

/*
 * This file is part of Bootstrap CMS.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\BootstrapCMS\Http\Controllers;

use GrahamCampbell\BootstrapCMS\Http\Requests\CategoryRequest;
use GrahamCampbell\BootstrapCMS\Models\Category;
use GrahamCampbell\BootstrapCMS\Services\CategoriesService;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Request;

/**
 * This is the comment controller class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class CategoryController extends AbstractController
{
    /**
     * @var CategoriesService
     */
    protected $categoriesService;

    /**
     * CategoryController constructor.
     *
     * @param CategoriesService $categoriesService
     */
    public function __construct(CategoriesService $categoriesService)
    {
        $this->categoriesService = $categoriesService;

        parent::__construct();
    }

    /**
     * Render create category form.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showCreateForm()
    {
        return view('categories.create');
    }

    /**
     * Show categories list.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showCategories()
    {
        return view('categories.show', ['categories' => Category::all()]);
    }

    /**
     * Create category request
     *
     * @param CategoryRequest $request
     * @return Redirector
     */
    public function createCategory(CategoryRequest $request)
    {
        $pages = $request->get('pages');
        $category = new Category(['name' => $request->get('name')]);
        $category->save();

        if ($category) {
            $this->categoriesService->saveCategoryPages($category, $pages);

            flash()->{'success'}('Category successfully created.');

            return redirect()->route('show.categories');
        }

        flash()->{'warning'}('Something went wrong. Please, resubmit form.');

        return redirect()->back();
    }

    /**
     * Delete category.
     */
    public function deleteCategory()
    {
        $id = Request::get('id');

        $category = Category::find($id);

        if ($category) {
            $this->categoriesService->deleteCategoryPages($category);

            $category->delete();
        }
    }

    /**
     * Show edit category.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editCategoryForm($id)
    {
        $category = Category::find($id);

        if ($category) {
            $category->pages = $this->categoriesService->getCategoryPages($category);

            return view('categories.edit', ['category' => $category, 'id' => $id]);
        }

        flash()->{'warning'}('There is no category with id ' . $id);

        return redirect()->back();
    }

    /**
     * Edit category.
     *
     * @param CategoryRequest $request
     * @param int $id
     * @return Redirector
     */
    public function editCategory(CategoryRequest $request, $id)
    {
        $pages = $request->get('pages');
        $category = Category::find($id);

        if ($category) {
            $category->name = $request->get('name');
            $category->save();

            $this->categoriesService->deleteCategoryPages($category);
            $this->categoriesService->saveCategoryPages($category, $pages);

            flash()->{'success'}('Category successfully updated.');

            return redirect()->route('show.categories');
        }

        flash()->{'warning'}('Something went wrong. Please, resubmit form.');

        return redirect()->back();
    }

    /**
     * Search pages.
     *
     * @return \Illuminate\Http\Response
     */
    protected function searchCategories()
    {
        return Category::where('name', 'like', Request::get('query') . '%')->get(['id', 'name as text']);
    }
}
