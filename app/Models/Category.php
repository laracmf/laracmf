<?php

/*
 * This file is part of Bootstrap CMS.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\BootstrapCMS\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * This is the comment model class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class Category extends Model
{
    protected $fillable = ['name'];

    /**
     * Returns current category pages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function pages()
    {
        return $this
            ->belongsToMany('GrahamCampbell\BootstrapCMS\Models\Page', 'categories_pages', 'category_id', 'page_id');
    }
}
