<?php

namespace App\Http\Controllers\Admin\Games\Gamemodes;

use App\Models\Game;
use App\Models\Gamemode;

class DeleteController extends BaseController
{
    public function delete(Game $game, Gamemode $gamemode)
    {
        $gamemode->delete();
        
        return redirect()->back()->with('success', trans('app.admin.gamemodes.deleted'));
    }
}
