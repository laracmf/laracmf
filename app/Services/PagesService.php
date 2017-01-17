<?php

namespace GrahamCampbell\BootstrapCMS\Services;

use GrahamCampbell\BootstrapCMS\Models\Page;
use GrahamCampbell\BootstrapCMS\Models\CategoriesPages;
use GrahamCampbell\Credentials\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\ObjectDataRow;

/**
 * Class PagesService
 *
 * @package GrahamCampbell\BootstrapCMS\Services
 */
class PagesService
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

    /**
     * Generate pages grid.
     *
     * @return object
     */
    public function getPagesGrid()
    {
        $callback = function ($val, ObjectDataRow $row) {
            if ($val) {
                return view('partials.pagesOptions', ['page' =>  $row->getSrc()]);
            }
        };

        $creatorCallback = function ($val, ObjectDataRow $row) {
            if ($val) {
                $user = User::find(($row->getSrc())->user_id);

                if ($user) {
                    return $user->first_name . ' ' .$user->last_name;
                }
            }
        };

        $filterFunction = function($val, EloquentDataProvider $provider) {
            $provider->getBuilder()
                ->join('users', 'pages.user_id', '=', 'users.id')
                ->where('users.first_name', 'like', '%' . trim($val) . '%')
                ->orWhere('users.last_name', 'like', '%' . trim($val) . '%');
        };

        return $this->gridService->generateGrid(
            new Page(),
            [
                'title' => [
                    'filter' => 'like'
                ],
                'nav_title' => [
                    'label' => 'Navigation title',
                    'filter' => 'like'
                ],
                'user_id' => [
                    'label' => 'Creator',
                    'callback' => $creatorCallback,
                    'filter' => 'like',
                    'function' => $filterFunction
                ],
                'created_at' => [
                    'label' => 'Created',
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
