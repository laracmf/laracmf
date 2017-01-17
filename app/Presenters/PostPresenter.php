<?php

namespace App\Presenters;

use GrahamCampbell\Credentials\Presenters\AuthorPresenterTrait;
use McCool\LaravelAutoPresenter\BasePresenter;

class PostPresenter extends BasePresenter
{
    use AuthorPresenterTrait, OwnerPresenterTrait, ContentPresenterTrait;
}
