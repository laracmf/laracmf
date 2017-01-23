<?php

namespace App\Models;

class Category extends AbstractModel
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
            ->belongsToMany('App\Models\Page', 'categories_pages', 'category_id', 'page_id');
    }
}
