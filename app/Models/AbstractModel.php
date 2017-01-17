<?php

namespace App\Models;

use GrahamCampbell\Credentials\Models\AbstractModel as BaseAbstractModel;
use App\Models\ModelInterface;

abstract class AbstractModel extends BaseAbstractModel implements ModelInterface
{
    /**
     * Return class name
     *
     * @return string
     */
    public function getClassName()
    {
        return static::class;
    }
}