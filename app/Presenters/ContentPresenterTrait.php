<?php

namespace App\Presenters;

use GrahamCampbell\Markdown\Facades\Markdown;

trait ContentPresenterTrait
{
    /**
     * Get the content.
     *
     * @return string
     */
    public function content()
    {
        return Markdown::convertToHtml($this->getWrappedObject()->body);
    }
}
