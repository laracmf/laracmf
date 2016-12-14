<?php

namespace GrahamCampbell\BootstrapCMS\Models;

use GrahamCampbell\Credentials\Models\AbstractModel as BaseAbstractModel;
use GrahamCampbell\BootstrapCMS\Models\ModelInterface;

/**
 * This is the abstract model class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
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