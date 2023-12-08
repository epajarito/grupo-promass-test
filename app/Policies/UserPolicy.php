<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user can create a new user.
     *
     * @param  User  $user
     * @return bool
    */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the given user can update the given user.
     *
     * @param User $user
     * @param User $model
     * @return bool
     */
    public function update(User $user, User $model): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->id === $model->id;
    }

    /**
     * Determine if the given user can delete any user.
     *
     * @param User $user
     * @return bool
     */
    public function delete(User $user, User $model): bool
    {
        return $user->isAdmin() && $model->id != $user->id;
    }
}
