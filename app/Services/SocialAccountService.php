<?php

namespace GrahamCampbell\BootstrapCMS\Services;

class SocialAccountService implements SociableInterface
{
    /**
     * Create user account based on user data from github.
     */
    public function saveGithubUser($user, $model)
    {
        $model->email = $user->email;
        $model->first_name = $user->name;

        return $model;
    }
}