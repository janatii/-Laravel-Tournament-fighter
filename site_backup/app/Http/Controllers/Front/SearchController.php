<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $this->validate($request, [
            'search' => 'present|nullable|string'
        ]);
        
        $search = $request->input('search');
        
        $resultsPlayers = User::where('username', 'like', '%' . $search . '%')->limit(12)->get();
        $resultsTeams = Team::whereGameId($request->gameSelected->id)->where('name', 'like', '%' . $search . '%')->limit(10)->get();
        
        return view('front.search', compact('search', 'resultsPlayers', 'resultsTeams'));
    }
}
