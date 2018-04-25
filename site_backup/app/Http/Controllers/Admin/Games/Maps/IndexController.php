<?php

namespace App\Http\Controllers\Admin\Games\Maps;

use App\Models\Game;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    public function index(Request $request, Game $game)
    {
        $maps = $game->maps;
        
        return view('admin.games.maps.index', compact('game', 'maps'));
    }
}
