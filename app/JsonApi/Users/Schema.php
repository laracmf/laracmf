<?php

namespace App\JsonApi\Users;

use CloudCreativity\LaravelJsonApi\Schema\EloquentSchema;

class Schema extends EloquentSchema
{
    /**
     * @var string
     */
    const RESOURCE_TYPE = 'users';

    /**
     * @var array
     */
    protected $attributes = [
        'first_name',
        'email',
    ];

    /**
     * @return string
     */
    public function getResourceType()
    {
        return self::RESOURCE_TYPE;
    }
}

