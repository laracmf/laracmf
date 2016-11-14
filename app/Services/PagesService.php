<?php

namespace GrahamCampbell\BootstrapCMS\Services;

use GrahamCampbell\BootstrapCMS\Models\Page;
use GrahamCampbell\BootstrapCMS\Models\CategoriesPages;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class PagesService
 *
 * @package GrahamCampbell\BootstrapCMS\Services
 */
class PagesService
{
    /**
     * Get page categories.
     *
     * @param Page $page
     *
     * @return Collection
     */
    public function getPageCategories(Page $page)
    {
        return CategoriesPages::join('pages', 'pages.id', '=', 'categories_pages.page_id')
            ->join('categories', 'categories.id', '=', 'categories_pages.category_id')
            ->where('pages.id', '=', $page->id)
            ->get(
                [
                    'categories.id',
                    'categories.name'
                ]
            );
    }

    /**
     * Create category pages relationship.
     *
     * @param Page $page
     * @param array $data
     */
    public function savePageCategories(Page $page, $data)
    {
        $page->categories()->sync($data);
    }

    /**
     * Delete category pages relationship.
     *
     * @param Page $page
     */
    public function deletePageCategories(Page $page)
    {
        $page->categories()->detach();
    }
}
