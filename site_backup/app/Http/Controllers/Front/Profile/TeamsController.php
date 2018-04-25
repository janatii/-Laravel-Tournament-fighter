<?php

namespace App\Http\Controllers\Front\Profile;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class TeamsController extends BaseProfileController
{
    public function index(Request $request, $subdomain, $pseudo)
    {
        $user = $this->loadUser($pseudo);
        $teams = $user->teams()->with('members')->where('game_id', $request->gameSelected->id)->get();
        $candidatures = $user->candidatures()->with('members')->where('game_id', $request->gameSelected->id)->get();
        $invites = $user->invites()->with('members')->where('game_id', $request->gameSelected->id)->get();
        
        $score = $user->getScore($request->gameSelected);
        
        $networks = [];
        foreach ($user->networks as $network) {
            $networks[$network->name] = [
                'identifier' =>$network->pivot->identifier,
                'logo' =>$network->logo,
            ];
        }
        
        return view('front.profile.teams', compact('user', 'teams', 'candidatures', 'invites', 'score', 'networks'));
    }
    
    public function createTeam(Request $request, $subdomain, User $user)
    {
        $this->authorize('update', $user);
        
        $this->validate($request, [
            'team-name' => 'required|string|min:4|max:15|regex:/^[A-Za-z0-9\-\_\ ]+$/|unique:teams,name',
        ]);
        
        $nbTeamsLimit = $request->gameSelected->max_teams_per_player;
        if ($user->teams->where('game_id', $request->gameSelected->id)->count() >= $nbTeamsLimit) {
            return response()->json(['error' => trans('app.front.profile.error-too-many-teams', ['limit' => $nbTeamsLimit])])->setStatusCode(422);
        }
        
        $newTeam = new Team();
        $newTeam->name = trim($request->input('team-name'));
        $newTeam->slug = str_slug($newTeam->name);
        $newTeam->score = $user->games()->find($request->gameSelected->id)->pivot->score;
        $newTeam->game()->associate($request->gameSelected);
        $newTeam->owner()->associate($user);
        $newTeam->save();
    
        $newTeam->members()->attach($user, ['role' => 'MANAGER']);
    
        return response()->json(['redirect' => route_with_subdomain('team_main', ['teamname' => $newTeam->name])]);
    }
}