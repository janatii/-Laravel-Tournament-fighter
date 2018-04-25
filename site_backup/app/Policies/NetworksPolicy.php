<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Network;
use Illuminate\Auth\Access\HandlesAuthorization;

class NetworksPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the network.
     *
     * @param  User  $user
     * @param  Network  $network
     * @return mixed
     */
    public function view(User $user, Network $network)
    {
        return true;
    }

    /**
     * Determine whether the user can create network.
     *
     * @param  User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->can('admin:networks:create');
    }

    /**
     * Determine whether the user can update the network.
     *
     * @param  User  $user
     * @param  Network  $network
     * @return mixed
     */
    public function update(User $user, Network $network)
    {
        return $user->can('admin:networks:edit');
    }

    /**
     * Determine whether the user can delete the network.
     *
     * @param  User  $user
     * @param  Network  $network
     * @return mixed
     */
    public function delete(User $user, Network $network)
    {
        return $user->can('admin:networks:delete');
    }
}
