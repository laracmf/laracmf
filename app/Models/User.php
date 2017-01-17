<?php

namespace App\Models;

use App\Models\Relations\HasManyCommentsTrait;
use App\Models\Relations\HasManyEventsTrait;
use App\Models\Relations\HasManyPagesTrait;
use App\Models\Relations\HasManyPostsTrait;
use GrahamCampbell\Credentials\Models\User as CredentialsUser;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableInterface;
use Tymon\JWTAuth\Contracts\JWTSubject as AuthenticatableUserContract;

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
        return 'App\Presenters\UserPresenter';
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
