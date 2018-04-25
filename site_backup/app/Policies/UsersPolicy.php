<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UsersPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the user.
     *
     * @param  User  $user
     * @param  User  $userAccessed
     * @return mixed
     */
    public function view(User $user, User $userAccessed)
    {
        return true;
    }

    /**
     * Determine whether the user can create users.
     *
     * @param  User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->can('admin:users:create');
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param  User  $user
     * @param  User  $userAccessed
     * @return mixed
     */
    public function update(User $user, User $userAccessed)
    {
        if ($userAccessed->isSuperAdmin()) {
            return false;
        }
        
        return $user->can('admin:users:edit') || $user->id === $userAccessed->id;
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @param  User  $user
     * @param  User  $userAccessed
     * @return mixed
     */
    public function delete(User $user, User $userAccessed)
    {
        if ($userAccessed->isSuperAdmin()) {
            return false;
        }
        return $user->can('admin:users:delete');
    }
    
    /**
     * @param User $user
     *
     * @return bool
     */
    public function joinATraining(User $user)
    {
        $activeTeam = $user->activeTeam;
        $matchBlocking = $user->getCurrentMatch();
        if (isset($activeTeam) && !isset($matchBlocking)) {
            return true;
        }
        return false;
    }
}
