<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Game;
use Illuminate\Auth\Access\HandlesAuthorization;

class GamesPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the platform.
     *
     * @param  User  $user
     * @param  Game  $game
     * @return mixed
     */
    public function view(User $user, Game $game)
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
        return $user->can('admin:games:create');
    }

    /**
     * Determine whether the user can update the platform.
     *
     * @param  User  $user
     * @param  Game  $game
     * @return mixed
     */
    public function update(User $user, Game $game)
    {
        return $user->can('admin:games:edit');
    }

    /**
     * Determine whether the user can delete the platform.
     *
     * @param  User  $user
     * @param  Game  $game
     * @return mixed
     */
    public function delete(User $user, Game $game)
    {
        return $user->can('admin:games:delete');
    }
    
    public function createTeam(User $user, Game $game)
    {
        return $user->teams->where('game_id', $game->id)->count() < $game->max_teams_per_player;
    }
    
    public function joinATraining(User $user, Game $game)
    {
        if ($user->can('join-a-training', User::class)) {
            return $user->activeTeam->game->id == $game->id;
        }
        return false;
    }
}
