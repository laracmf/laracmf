<?php

namespace GrahamCampbell\BootstrapCMS\JsonApi\Users;

use CloudCreativity\JsonApi\Http\Requests\RequestHandler;

class Request extends RequestHandler
{

    /**
     * @var array
     */
    protected $hasOne = [
        //
    ];

    /**
     * @var array
     */
    protected $hasMany = [
        //
    ];

    /**
     * @var array
     */
    protected $allowedFilteringParameters = [
        'id',
        'first_name'
    ];

    protected $allowedSortParameters = [
        'first_name',
        'email'
    ];
}

