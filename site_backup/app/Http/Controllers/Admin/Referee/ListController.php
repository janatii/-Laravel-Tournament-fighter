<?php

namespace App\Http\Controllers\Admin\Referee;

use App\Http\Controllers\Controller;
use App\Models\Match;

class ListController extends Controller
{
    public function page()
    {
        $matchs = Match::with(['game', 'squad1.team', 'squad2.team'])->where('wait_referee', 1)->paginate(20);
        
        return view('admin.referee.list', compact('matchs'));
    }
}
