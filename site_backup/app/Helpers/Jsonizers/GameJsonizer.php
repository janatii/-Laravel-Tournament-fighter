<?php

namespace App\Helpers\Jsonizers;

use App\Models\Game;
use App\Models\Gamemode;
use App\Models\Map;
use Illuminate\Support\Collection;

class GameJsonizer
{
    /**
     * @param \App\Models\Game|null $game
     *
     * @return string
     *
     */
    public function format(?Game $game)
    {
        $data = null;
        
        if ($game) {
            $game->load('maps.gamemodes');
            
            $data = [
                'id' => $game->id,
                'name' => $game->name,
                'subdomain' => $game->subdomain,
                'bo_list' => $game->getBoListArrayWithText(),
                'vs_list' => $game->getVsListArrayWithText(),
                'gamemodes' => $this->getGamemodesArray($game->gamemodes),
                'classic_modes_list' => $game->getClassicModesSequenceIds(),
                'maps' => $this->getMapsArray($game->maps),
            ];
        }
        
        return json_encode($data);
    }
    
    /**
     * @param Collection|Gamemode[] $gamemodes
     *
     * @return array
     */
    private function getGamemodesArray(Collection $gamemodes)
    {
        return $gamemodes->map(function (Gamemode $gamemode) {
            return [
                'id' => $gamemode->id,
                'name' => $gamemode->name,
                'abbrev' => $gamemode->abbrev,
            ];
        })->toArray();
    }
    
    /**
     * @param Collection|Map[] $maps
     *
     * @return array
     */
    private function getMapsArray(Collection $maps)
    {
        return $maps->map(function (Map $map) {
            return [
                'id' => $map->id,
                'name' => $map->name,
                'logo' => $map->logo,
                'gamemodes' => $map->gamemodes->pluck('id'),
            ];
        })->toArray();
    }
}