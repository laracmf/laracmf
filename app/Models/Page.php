<?php

namespace App\Models;

use Exception;
use GrahamCampbell\Credentials\Models\Relations\BelongsToUserTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use McCool\LaravelAutoPresenter\HasPresenter;

class Page extends AbstractModel implements HasPresenter
{
    use BelongsToUserTrait, SoftDeletes;

    /**
     * The table the pages are stored in.
     *
     * @var string
     */
    protected $table = 'pages';

    /**
     * The model name.
     *
     * @var string
     */
    public static $name = 'page';

    /**
     * The properties on the model that are dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The columns to select when displaying an index.
     *
     * @var array
     */
    public static $index = ['id', 'slug', 'title', 'nav_title'];

    /**
     * The max pages per page when displaying a paginated index.
     *
     * @var int
     */
    public static $paginate = 10;

    /**
     * The columns to order by when displaying an index.
     *
     * @var string
     */
    public static $order = 'slug';

    /**
     * The direction to order by when displaying an index.
     *
     * @var string
     */
    public static $sort = 'asc';

    /**
     * The page validation rules.
     *
     * @var array
     */
    public static $rules = [
        'title'      => 'required',
        'nav_title'  => 'required',
        'slug'       => 'required|alpha_dash',
        'body'       => 'required',
        'show_title' => 'required',
        'show_nav'   => 'required',
        'user_id'    => 'required',
    ];

    /**
     * Get the presenter class.
     *
     * @return string
     */
    public function getPresenterClass()
    {
        return 'App\Presenters\PagePresenter';
    }

    /**
     * Before deleting an existing model.
     *
     * @throws \Exception
     *
     * @return void
     */
    public function beforeDelete()
    {
        if ($this->slug == 'home') {
            throw new Exception('You cannot delete the homepage.');
        }
    }

    /**
     * Returns current category pages.
     *
     * @return BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(
            'App\Models\Category',
            'categories_pages',
            'page_id',
            'category_id'
        );
    }
}
