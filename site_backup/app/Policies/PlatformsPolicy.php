<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Platform;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlatformsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the platform.
     *
     * @param  User  $user
     * @param  Platform  $platform
     * @return mixed
     */
    public function view(User $user, Platform $platform)
    {
        return true;
    }

    /**
     * Determine whether the user can create platforms.
     *
     * @param  User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->can('admin:platforms:create');
    }

    /**
     * Determine whether the user can update the platform.
     *
     * @param  User  $user
     * @param  Platform  $platform
     * @return mixed
     */
    public function update(User $user, Platform $platform)
    {
        return $user->can('admin:platforms:edit');
    }

    /**
     * Determine whether the user can delete the platform.
     *
     * @param  User  $user
     * @param  Platform  $platform
     * @return mixed
     */
    public function delete(User $user, Platform $platform)
    {
        return $user->can('admin:platforms:delete');
    }
}
