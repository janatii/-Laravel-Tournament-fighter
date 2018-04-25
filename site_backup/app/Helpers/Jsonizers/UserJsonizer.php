<?php

namespace App\Helpers\Jsonizers;

use App\Models\Game;
use App\Models\Match;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Collection;

class UserJsonizer
{
    /**
     * @param \App\Models\User|null $user
     *
     * @param \App\Models\Game|null $game
     *
     * @return string
     */
    public function format(?User $user, ?Game $game)
    {
        $data = null;
        
        if ($user) {
            $data = [
                'id' => $user->id,
                'username' => $user->username,
                'premium' => $user->isPremium(),
                'activeTeam' => $this->getActiveTeamArray($user->activeTeam),
                'hasMatch' => $this->getCurrentMatchArray($user->getCurrentMatch()),
            ];
        }
        
        return json_encode($data);
    }
    
    private function getActiveTeamArray(?Team $activeTeam)
    {
        if (!$activeTeam) {
            return null;
        }
        
        return [
            'id' => $activeTeam->id,
            'name' => $activeTeam->name,
            'slug' => $activeTeam->slug,
            'game' => $this->getGameArray($activeTeam->game),
            'members' => $this->getTeamMembersArray($activeTeam->members),
        ];
    }
    
    private function getTeamMembersArray(Collection $members)
    {
        return $members->map(function (User $member) {
            return [
                'id' => $member->id,
                'username' => $member->username,
                'role' => $member->pivot->role,
                'avatar' => $member->avatar,
            ];
        });
    }
    
    /**
     * @param Match|null $match
     *
     * @return array|null
     */
    private function getCurrentMatchArray(?Match $match): ?array
    {
        if ($match) {
            return [
                'id' => $match->id,
                'game' => $this->getGameArray($match->game),
                'status' => $match->status,
            ];
        }
        return null;
    }
    
    /**
     * @param Game|null $game
     *
     * @return array|null
     */
    private function getGameArray(?Game $game): ?array
    {
        if ($game) {
            return [
                'id' => $game->id,
                'name' => $game->name,
                'platform' => $game->platform->name,
            ];
        }
        return null;
    }
}