<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReportPolicy
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
        return ($user->role_id == '1' || $user->role_id == '2') && $user->is_active;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return ($user->role_id == '1' || $user->role_id == '2') && $user->is_active;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @return mixed
     */
    public function view(User $user)
    {
        return ($user->role_id == '1' || $user->role_id == '2') && $user->is_active;
    }
}
