<?php

namespace App\Services;

use App\Models\Category;
use App\Models\CategoriesPages;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class PagesService
 * @package App\Services
 */
class CategoriesService
{
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
}
