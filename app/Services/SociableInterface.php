<?php

namespace App\Services;

use App\Models\User;

interface SociableInterface
{
    /**
     * @param \Laravel\Socialite\Two\User $user
     * @param User $model
     * @return User
     */
    public function saveGithubUser($user, $model);
}