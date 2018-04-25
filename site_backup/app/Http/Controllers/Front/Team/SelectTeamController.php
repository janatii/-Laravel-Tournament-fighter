<?php

namespace App\Http\Controllers\Front\Team;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SelectTeamController extends BaseTeamController
{
    public function select(Request $request, $subdomain, Team $team)
    {
        $user = Auth::user();
        
        if (!$user->teams->contains($team)) {
            return abort(403);
        }
        
        $user->activeTeam()->associate($team);
        $user->save();
        
        return back();
    }
}
