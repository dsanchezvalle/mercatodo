<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThemePolicy
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
}
