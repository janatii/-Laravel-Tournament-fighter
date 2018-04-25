<?php

namespace App\Http\Controllers\Admin\Games\Gamemodes;

use App\Http\Requests\GamemodeEditRequest;
use App\Models\Game;
use App\Models\Gamemode;

class EditController extends BaseController
{
    public function page(Game $game, Gamemode $gamemode)
    {
        return view('admin.games.gamemodes.edit', compact('game', 'gamemode'));
    }

    public function save(GamemodeEditRequest $request, Game $game, Gamemode $gamemode)
    {
        $gamemode->name = $request->input('name');
        $gamemode->abbrev = $request->input('abbrev');
        $gamemode->save();
        
        return redirect()->back()->with('success', trans('app.admin.gamemodes.updated'));
    }
}
