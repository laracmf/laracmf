<?php

namespace App\Models;

interface ModelInterface
{
    /**
     * Get model namespace
     *
     * @return string
     */
    public function getClassName();
}