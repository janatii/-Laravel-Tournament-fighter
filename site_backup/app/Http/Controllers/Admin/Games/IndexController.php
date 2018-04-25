<?php

namespace App\Http\Controllers\Admin\Games;

use App\Models\Game;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    public function index(Request $request)
    {
        $games = Game::with('platform')->orderBy('order')->get();
        
        return view('admin.games.index', compact('games'));
    }
}
