<?php

namespace App\Models;

class ThemeUser extends AbstractModel
{
    /**
     * The table the posts are stored in.
     *
     * @var string
     */
    protected $table = 'theme_user';

    /**
     * @var array
     */
    protected $fillable = ['name', 'user_id'];
}
