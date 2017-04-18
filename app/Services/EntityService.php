<?php

namespace App\Services;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EntityService
{
    /**
     * Check the comment model.
     *
     * @param mixed $entity
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @return void
     */
    public function checkEntity($entity)
    {
        if (!$entity) {
            throw new NotFoundHttpException('Comment Not Found.');
        }
    }
}
