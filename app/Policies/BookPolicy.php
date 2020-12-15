<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user): bool
    {
        return ($user->role_id == '1' || $user->role_id == '2') && $user->is_active;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @return mixed
     */
    public function view(User $user): bool
    {
        return $user->is_active;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user): bool
    {
        return ($user->role_id == '1' || $user->role_id == '2') && $user->is_active;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @return mixed
     */
    public function update(User $user): bool
    {
        return ($user->role_id == '1' || $user->role_id == '2') && $user->is_active;
    }

    /**
     * Determine whether the user can import the model.
     *
     * @param User $user
     * @return mixed
     */
    public function import(User $user): bool
    {
        return ($user->role_id == '1' || $user->role_id == '2') && $user->is_active;
    }

    /**
     * Determine whether the user can export the model.
     *
     * @param User $user
     * @return mixed
     */
    public function export(User $user): bool
    {
        return ($user->role_id == '1' || $user->role_id == '2') && $user->is_active;
    }
}
