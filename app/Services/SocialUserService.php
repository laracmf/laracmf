<?php

namespace GrahamCampbell\BootstrapCMS\Services;

use GrahamCampbell\BootstrapCMS\Models\User;
use Webpatser\Uuid\Uuid;

class SocialUserService
{
    /**
     * Create user account based on user data from github.
     *
     * @param \Laravel\Socialite\Two\User $user
     * @return User
     */
    public function saveGithubUser($user)
    {
        $model = new User();

        $model->email = $user->email;
        $model->first_name = $user->name;
        $model->password = $model->hash(rand(1, 10));
        $model->confirm_token = Uuid::generate(4);

        $model->save();

        return $model;
    }
}