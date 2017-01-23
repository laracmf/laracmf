<?php

namespace App\Services;

use App\Models\Category;
use App\Models\CategoriesPages;
use App\Services\GridService;
use Illuminate\Database\Eloquent\Collection;
use Nayjest\Grids\ObjectDataRow;

/**
 * Class PagesService
 * @package App\Services
 */
class CategoriesService
{
    /**
     * @var GridService
     */
    public $gridService;

    /**
     * PagesService constructor.
     *
     * @param GridService $gridService
     */
    public function __construct(GridService $gridService)
    {
        $this->gridService = $gridService;
    }

    /**
     * Create category pages relationship.
     *
     * @param Category $category
     * @param array $data
     */
    public function saveCategoryPages(Category $category, $data)
    {
        $category->pages()->sync($data);
    }

    /**
     * Delete category pages relationship.
     *
     * @param Category $category
     */
    public function deleteCategoryPages(Category $category)
    {
        $category->pages()->detach();
    }

    /**
     * Get category pages.
     *
     * @param Category $category
     *
     * @return Collection
     */
    public function getCategoryPages(Category $category)
    {
        return CategoriesPages::join('pages', 'pages.id', '=', 'categories_pages.page_id')
            ->join('categories', 'categories.id', '=', 'categories_pages.category_id')
            ->where('categories.id', '=', $category->id)
            ->get(
                [
                    'pages.id',
                    'pages.title'
                ]
            );
    }

    /**
     * Generate grid for categories model.
     *
     * @return object
     */
    public function generateGrid()
    {
        $callback = function ($val, ObjectDataRow $row) {
            if ($val) {
                return view('partials.categoriesOptions', ['category' =>  $row->getSrc()]);
            }
        };

        return $this->gridService->generateGrid(
            new Category(),
            [
                'name' => [
                    'filter' => 'like'
                ],
                'id' => [
                    'label' => 'Options',
                    'callback' => $callback,
                    'sortable' => false
                ]
            ]
        );
    }
}
