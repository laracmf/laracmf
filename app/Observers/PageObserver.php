<?php

namespace App\Observers;

use App\Facades\PageRepository;

class PageObserver
{
    /**
     * Handle a page creation.
     *
     * @return void
     */
    public function created()
    {
        PageRepository::refresh();
    }

    /**
     * Handle a page update.
     *
     * @return void
     */
    public function updated()
    {
        PageRepository::refresh();
    }

    /**
     * Handle a page deletion.
     *
     * @return void
     */
    public function deleted()
    {
        PageRepository::refresh();
    }

    /**
     * Handle a page save.
     *
     * @return void
     */
    public function saved()
    {
        PageRepository::refresh();
    }

    /**
     * Handle a page restore.
     *
     * @return void
     */
    public function restored()
    {
        PageRepository::refresh();
    }
}
