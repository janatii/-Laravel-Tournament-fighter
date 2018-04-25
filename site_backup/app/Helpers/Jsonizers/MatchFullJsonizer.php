<?php

namespace App\Helpers\Jsonizers;

use App\Models\Game;
use App\Models\Gamemode;
use App\Models\Match;
use App\Models\Squad;
use App\Models\Team;
use App\Models\User;

class MatchFullJsonizer
{
    /**
     * @param \App\Models\Match $match
     *
     * @return array
     */
    public function format(Match $match)
    {
        $mode = $this->getMatchModeArray($match->fullGamemode);
    
        $squads = $this->getSquadsArray($match);
    
        $game = $this->getGameArray($match->game);
    
        return [
            'game' => $game,
            'id' => $match->id,
            'typeText' => matchtype_text($match->type),
            'type' => $match->type,
            'mode' => $mode,
            'boText' => bestof_text($match->bo),
            'bo' => $match->bo,
            'vsText' => versus_text($match->vs),
            'vs' => $match->vs,
            'betText' => bet_text($match->bet),
            'bet' => $match->bet,
            'squads' => $squads,
            'creator_id' => $match->creator->id,
            'premium' => $match->creator->isPremium(),
            'filter_score_min' => $match->filter_score_min,
            'filter_score_max' => $match->filter_score_max,
        ];
    }
    
    /**
     * @param \App\Models\Gamemode $mode
     *
     * @return array
     */
    private function getMatchModeArray(?Gamemode $mode): ?array
    {
        if ($mode) {
            return [
                'id' => $mode->id,
                'name' => $mode->name,
            ];
        } else {
            return [
                'id' => 0,
                'name' => trans('app.global.generic-texts.classic'),
            ];
        }
    }
    
    /**
     * @param \App\Models\Squad $squad
     *
     * @return array
     */
    private function getSquadMembersArray(?Squad $squad, Game $game): ?array
    {
        if (!$squad) {
            return null;
        }
        
        return $squad->members->map(function (User $user) use ($game) {
            $scores = $user->getScores($game);
            return [
                'id' => $user->id,
                'username' => $user->username,
                'premium' => $user->isPremium(),
                'score' => $scores->score,
                'win' => $scores->win,
                'lost' => $scores->lost,
            ];
        })->toArray();
    }
    
    /**
     * @param \App\Models\Team $team
     *
     * @return array
     */
    private function getTeamArray(Team $team): array
    {
        return [
            'id' => $team->id,
            'name' => $team->name,
            'slug' => $team->slug,
            'score' => $team->score,
            'win' => $team->win,
            'lost' => $team->lost,
        ];
    }
    
    /**
     * @param \App\Models\Match $match
     *
     * @return array
     */
    private function getSquadsArray(Match $match): array
    {
        return [
            $this->getSquadArray($match->squad1, $match->game),
            $this->getSquadArray($match->squad2, $match->game),
        ];
    }
    
    /**
     * @param \App\Models\Squad $squad
     *
     * @return array|null
     */
    private function getSquadArray(?Squad $squad, Game $game): ?array
    {
        if (!$squad) {
            return null;
        }
        
        $team = $this->getTeamArray($squad->team);
        $members = $this->getSquadMembersArray($squad, $game);
        
        return [
            'team' => $team,
            'members' => $members,
        ];
    }
    
    /**
     * @param \App\Models\Game $game
     *
     * @return array
     */
    private function getGameArray(Game $game): array
    {
        return [
            'id' => $game->id,
            'name' => $game->name,
        ];
    }
}