<?php

namespace App\Http\Controllers\Admin\Games\Gamemodes;

use App\Http\Requests\GamemodeCreateRequest;
use App\Models\Game;
use App\Models\Gamemode;

class CreateController extends BaseController
{
    public function page(Game $game)
    {
        return view('admin.games.gamemodes.create', compact('game'));
    }
    
    public function save(GamemodeCreateRequest $request, Game $game)
    {
        $gamemode = new Gamemode();
        $gamemode->name = $request->input('name');
        $gamemode->abbrev = $request->input('abbrev');
        $gamemode->game()->associate($game);
        $gamemode->save();
        
        return redirect()->route('admin_gamemodes_list', ['game' => $game])->with('success', trans('app.admin.gamemodes.created'));
    }
}
