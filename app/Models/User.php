<?php

/*
 * This file is part of Bootstrap CMS.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\BootstrapCMS\Models;

use GrahamCampbell\BootstrapCMS\Models\Relations\HasManyCommentsTrait;
use GrahamCampbell\BootstrapCMS\Models\Relations\HasManyEventsTrait;
use GrahamCampbell\BootstrapCMS\Models\Relations\HasManyPagesTrait;
use GrahamCampbell\BootstrapCMS\Models\Relations\HasManyPostsTrait;
use GrahamCampbell\Credentials\Models\User as CredentialsUser;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableInterface;
use Tymon\JWTAuth\Contracts\JWTSubject as AuthenticatableUserContract;

/**
 * This is the user model class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class User extends CredentialsUser implements ModelInterface, AuthenticatableUserContract, AuthenticatableInterface
{
    use HasManyPagesTrait,
        HasManyPostsTrait,
        HasManyEventsTrait,
        HasManyCommentsTrait,
        Authenticatable;

    /**
     * Get the presenter class.
     *
     * @return string
     */
    public function getPresenterClass()
    {
        return 'GrahamCampbell\BootstrapCMS\Presenters\UserPresenter';
    }

    /**
     * Before deleting an existing model.
     *
     * @return void
     */
    public function beforeDelete()
    {
        $this->deletePages();
        $this->deletePosts();
        $this->deleteEvents();
        $this->deleteComments();
    }

    /**
     * Return class name
     *
     * @return string
     */
    public function getClassName()
    {
        return get_class($this);
    }

    /**
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();  // Eloquent model method
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'user' => [
                'id' => $this->id
            ]
        ];
    }
}
