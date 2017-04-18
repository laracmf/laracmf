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
     * @param $query
     * @return mixed
     */
    public static function search($query)
    {
        return Category::where('name', 'like', $query . '%')->get(['id', 'name as text']);
    }

}
