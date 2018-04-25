<?php

namespace App\Helpers\Jsonizers;

use App\Models\Game;
use App\Models\Match;

class MatchShortJsonizer
{
    /**
     * @param \App\Models\Match $match
     *
     * @return array
     */
    public function format(Match $match)
    {
        $game = $this->getGameArray($match->game);
    
        return [
            'game' => $game,
            'id' => $match->id,
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