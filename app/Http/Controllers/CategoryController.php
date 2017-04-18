<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\CategoriesService;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Input;

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
        $pages = $request->input('pages');
        $category = new Category(['name' => $request->input('name')]);
        $category->save();

        if ($category) {
            if (is_array($pages)) {
                $this->categoriesService->saveCategoryPages($category, $pages);
            }

            flash()->success('Category successfully created.');

            return redirect()->route('show.categories');
        }

        flash()->warning('Something went wrong. Please, resubmit form.');

        return redirect()->back();
    }

    /**
     * Delete category.
     */
    public function deleteCategory()
    {
        $id = Input::get('id');

        $category = Category::find($id);
        $flash = [
            'level' => 'warning',
            'message' => 'Ooops, something went wrong.'
        ];

        if ($category) {
            $this->categoriesService->deleteCategoryPages($category);

            if ($category->delete()) {
                $flash = [
                    'level' => 'success',
                    'message' => 'Category successfully deleted.'
                ];
            }
        }

        flash()->{$flash['level']}($flash['message']);
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

        flash()->warning('There is no category with id ' . $id);

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

            if (is_array($pages)) {
                $this->categoriesService->saveCategoryPages($category, $pages);
            }

            flash()->success('Category successfully updated.');

            return redirect()->route('show.categories');
        }

        flash()->warning('Something went wrong. Please, resubmit form.');

        return redirect()->back();
    }

    /**
     * Search pages.
     *
     * @return \Illuminate\Http\Response
     */
    protected function searchCategories()
    {
        return Category::search(Request::get('query'))->get(['id', 'name as text']);
    }
}
