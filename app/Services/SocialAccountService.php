<?php

namespace GrahamCampbell\BootstrapCMS\Services;

use GrahamCampbell\BootstrapCMS\Models\User;

class SocialAccountService implements SociableInterface
{
    /**
     * Create user account based on user data from github.
     *
     * @param $user
     * @param User $model
     * @return User
     */
    public function saveGithubUser($user, $model)
    {
        $model->email = $user->email;
        $model->first_name = $user->name;

        return $model;
    }
}