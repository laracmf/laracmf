<?php

namespace GrahamCampbell\BootstrapCMS\Models;

interface ModelInterface
{
    /**
     * Get model namespace
     *
     * @return string
     */
    public function getClassName();
}