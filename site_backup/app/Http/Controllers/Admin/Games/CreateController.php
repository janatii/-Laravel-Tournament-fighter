<?php

namespace App\Http\Controllers\Admin\Games;

use App\Http\Requests\GameCreateRequest;
use App\Models\Game;
use App\Models\Network;
use App\Models\Platform;

class CreateController extends BaseController
{
    public function page()
    {
        $platforms = Platform::orderBy('order')->get();
        $networks = Network::orderBy('name')->get();
        
        return view('admin.games.create', compact('platforms', 'networks'));
    }
    
    public function save(GameCreateRequest $request)
    {
        $game = new Game();
        $game->name = $request->input('name');
        $game->subdomain = $request->input('subdomain');
        $game->order = $request->input('order');
        $game->max_players_per_team = $request->input('max_players_per_team');
        $game->max_teams_per_player = $request->input('max_teams_per_player');
        $game->max_teams_per_player_premium = $request->input('max_teams_per_player_premium');
        $game->bo_list = $request->input('bo_list');
        $game->vs_list = $request->input('vs_list');
        $game->classic_modes_list = $request->input('classic_modes_list');
        if ($request->hasFile('logo')) {
            $game->logo = $request->file('logo');
        }
        if ($request->hasFile('menu_logo')) {
            $game->menu_logo = $request->file('menu_logo');
        }
        if ($request->hasFile('logo_list_trainings')) {
            $game->logo_list_trainings = $request->file('logo_list_trainings');
        }
        if ($request->hasFile('banner')) {
            $game->banner = $request->file('banner');
        }
        $game->time_per_round = $request->input('time_per_round');
        $game->rules = $request->input('rules');
        $game->network()->associate($request->input('network'));
        $game->platform()->associate($request->input('platform'));
        $game->save();
        
        return redirect()->route('admin_games_list')->with('success', trans('app.admin.games.created'));
    }
}
