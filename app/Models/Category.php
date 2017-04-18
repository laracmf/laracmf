<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
            ->belongsToMany('App\Models\Page', 'categories_pages', 'category_id', 'page_id');
    }

    /**
     * Scope of search query
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', $search . '%');
    }

}
