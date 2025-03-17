<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function user_edit(User $user, User $currentuser) {
        return $user->id === $currentuser->id;
    }
}
