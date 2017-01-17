<?php

namespace App\Models\Relations;

trait HasManyPagesTrait
{
    /**
     * Get the page relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOneOrMany
     */
    public function pages()
    {
        return $this->hasMany('App\Models\Page');
    }

    /**
     * Delete all pages.
     *
     * @return void
     */
    public function deletePages()
    {
        foreach ($this->pages()->get(['id', 'slug']) as $page) {
            $page->delete();
        }
    }
}
