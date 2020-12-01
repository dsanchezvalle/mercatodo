<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  User $user
     * @return boolean
     */
    public function viewAny(User $user): bool
    {
        return $user->role_id == '1' && $user->is_active;

    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User $user
     * @return boolean
     */
    public function view(User $user): bool
    {
        return $user->role_id == '1' && $user->is_active;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User $user
     * @return boolean
     */
    public function create(User $user): bool
    {
        return $user->role_id == '1' && $user->is_active;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User $user
     * @return boolean
     */
    public function update(User $user): bool
    {
        return $user->role_id == '1' && $user->is_active;
    }
}
