<?php

namespace GrahamCampbell\BootstrapCMS\Services;

use GrahamCampbell\BootstrapCMS\Models\User;

interface SociableInterface
{
    /**
     * @param \Laravel\Socialite\Two\User $user
     * @param User $model
     * @return User
     */
    public function saveGithubUser($user, $model);
}