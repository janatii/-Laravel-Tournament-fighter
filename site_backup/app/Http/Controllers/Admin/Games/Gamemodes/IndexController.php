<?php

namespace App\Http\Controllers\Admin\Games\Gamemodes;

use App\Models\Game;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    public function index(Request $request, Game $game)
    {
        $gamemodes = $game->gamemodes;
        
        return view('admin.games.gamemodes.index', compact('game', 'gamemodes'));
    }
}
