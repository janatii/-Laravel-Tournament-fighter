<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamsPolicy
{
    use HandlesAuthorization;
    
    public function view(User $user, Team $team)
    {
        return true;
    }
    
    public function create(User $user, Team $team)
    {
        return $user->can('admin:teams:create');
    }
    
    public function update(User $user, Team $team)
    {
        return $user->can('admin:teams:edit') || $user->id === $team->owner->id;
    }
    
    public function delete(User $user, Team $team)
    {
        return $user->can('admin:teams:delete');
    }
    
    public function join(User $user, Team $team)
    {
        $nbTeamsInThisGame = $user->teamsByGame($team->game)->count();
        if ($user->isPremium() && $nbTeamsInThisGame > $team->game->max_teams_per_player_premium) {
            return false;
        }
        if (!$user->isPremium() && $nbTeamsInThisGame > $team->game->max_teams_per_player) {
            return false;
        }
        if ($user->bans->contains($team)) {
            return false;
        }
        if ($user->teams->contains($team)) {
            return false;
        }
        if ($user->candidatures->contains($team)) {
            return false;
        }
        if ($user->invites->contains($team)) {
            return false;
        }
        return true;
    }
    
    public function beAccepted(User $user, Team $team)
    {
        $nbTeamsInThisGame = $user->teamsByGame($team->game)->count();
        if ($user->isPremium() && $nbTeamsInThisGame > $team->game->max_teams_per_player_premium) {
            return false;
        }
        if (!$user->isPremium() && $nbTeamsInThisGame > $team->game->max_teams_per_player) {
            return false;
        }
        if ($user->bans->contains($team)) {
            return false;
        }
        if ($user->teams->contains($team)) {
            return false;
        }
        if ($team->hasMaxMembersCount()) {
            return false;
        }
        return true;
    }
    
    public function beInvited(User $user, Team $team)
    {
        $nbTeamsInThisGame = $user->teamsByGame($team->game)->count();
        if ($user->isPremium() && $nbTeamsInThisGame > $team->game->max_teams_per_player_premium) {
            return false;
        }
        if (!$user->isPremium() && $nbTeamsInThisGame > $team->game->max_teams_per_player) {
            return false;
        }
        if ($user->bans->contains($team)) {
            return false;
        }
        if ($user->invites->contains($team)) {
            return false;
        }
        if ($user->candidatures->contains($team)) {
            return false;
        }
        if ($user->teams->contains($team)) {
            return false;
        }
        if ($team->hasMaxMembersCount()) {
            return false;
        }
        return true;
    }
    
    public function abortCandidate(User $user, Team $team)
    {
        if ($user->candidatures->contains($team)) {
            return true;
        }
        return false;
    }
    
    public function leave(User $user, Team $team)
    {
        if ($user->teams->contains($team)) {
            if ($user->id != $team->owner->id) {
                return true;
            }
        }
        return false;
    }
    
    public function manage(User $user, Team $team)
    {
        if ($team->owner->id == $user->id) {
            return true;
        }
        
        if ($team->managers->contains($user)) {
            return true;
        }
        return false;
    }
    
    public function manageManagers(User $user, Team $team)
    {
        if ($team->owner->id == $user->id) {
            return true;
        }
        return false;
    }
    
    public function acceptInvite(User $user, Team $team)
    {
        return $this->manage($user, $team) && $user->invites->contains($team) && !$team->hasMaxMembersCount();
    }

    public function declineInvite(User $user, Team $team)
    {
        return $this->manage($user, $team) && $user->invites->contains($team);
    }
    
    public function invitePlayers(User $user, Team $team)
    {
        return $this->manage($user, $team) && !$team->hasMaxMembersCount();
    }
    
    public function banPlayers(User $user, Team $team)
    {
        return $this->manage($user, $team);
    }
    
    public function unbanPlayers(User $user, Team $team)
    {
        return $this->manage($user, $team);
    }
    
    public function seeCandidatesPlayers(User $user, Team $team)
    {
        if ($user->teams->contains($team)) {
            return true;
        }
        return false;
    }
    
    public function seeBannedPlayers(User $user, Team $team)
    {
        if ($user->teams->contains($team)) {
            return true;
        }
        return false;
    }
    
    public function seeInvitedPlayers(User $user, Team $team)
    {
        if ($user->teams->contains($team)) {
            return true;
        }
        return false;
    }
}
