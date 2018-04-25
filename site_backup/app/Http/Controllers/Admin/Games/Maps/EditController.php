<?php

namespace App\Http\Controllers\Admin\Games\Maps;

use App\Http\Requests\MapEditRequest;
use App\Models\Game;
use App\Models\Map;

class EditController extends BaseController
{
    public function page(Game $game, Map $map)
    {
        $gamemodes = $game->gamemodes()->get();
        
        return view('admin.games.maps.edit', compact('game', 'map', 'gamemodes'));
    }

    public function save(MapEditRequest $request, Game $game, Map $map)
    {
        $map->name = $request->input('name');
        if ($request->hasFile('logo')) {
            $map->logo = $request->file('logo');
        }
        $map->save();
        
        $map->gamemodes()->sync($request->input('gamemodes'));
        
        return redirect()->back()->with('success', trans('app.admin.maps.updated'));
    }
}
