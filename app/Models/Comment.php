<?php

namespace App\Models;

use App\Models\Relations\BelongsToPostTrait;
use GrahamCampbell\Credentials\Models\Relations\BelongsToUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use McCool\LaravelAutoPresenter\HasPresenter;

class Comment extends AbstractModel implements HasPresenter
{
    use BelongsToPostTrait, BelongsToUserTrait, SoftDeletes;

    /**
     * The model name.
     *
     * @var string
     */
    public static $name = 'comment';

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
    public static $index = ['id', 'body', 'user_id', 'created_at', 'version', 'approved'];

    /**
     * The columns to order by when displaying an index.
     *
     * @var string
     */
    public static $order = 'id';

    /**
     * The direction to order by when displaying an index.
     *
     * @var string
     */
    public static $sort = 'desc';

    /**
     * The comment validation rules.
     *
     * @var array
     */
    public static $rules = [
        'body'    => 'required',
        'user_id' => 'required',
        'post_id' => 'required',
    ];

    /**
     * Get the presenter class.
     *
     * @return string
     */
    public function getPresenterClass()
    {
        return 'App\Presenters\CommentPresenter';
    }
}
