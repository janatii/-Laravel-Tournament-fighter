<?php

namespace App\Http\Controllers\Admin\Games\Maps;

use App\Http\Requests\MapCreateRequest;
use App\Models\Game;
use App\Models\Map;

class CreateController extends BaseController
{
    public function page(Game $game)
    {
        $gamemodes = $game->gamemodes()->get();
        
        return view('admin.games.maps.create', compact('game', 'gamemodes'));
    }
    
    public function save(MapCreateRequest $request, Game $game)
    {
        $map = new Map();
        $map->name = $request->input('name');
        if ($request->hasFile('logo')) {
            $map->logo = $request->file('logo');
        }
        $map->game()->associate($game);
        $map->save();
        
        $map->gamemodes()->sync($request->input('gamemodes'));
        
        return redirect()->route('admin_maps_list', ['game' => $game])->with('success', trans('app.admin.maps.created'));
    }
}
