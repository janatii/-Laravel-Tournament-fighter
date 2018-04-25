<?php

namespace App\Http\Controllers\Front\Trainings;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function page(Request $request)
    {
        $user = Auth::user();
        
        $trainings = $this->getDisplayableTrainings($request->gameSelected, $user);
        
        return view('front.trainings.index', compact('trainings'));
    }
    
    private function getDisplayableTrainings(Game $gameSelected, ?User $user): \Illuminate\Support\Collection
    {
        $trainings = $gameSelected->matches()
              ->with(['game', 'fullGamemode', 'squad1.team', 'squad2.team', 'squad1.members', 'squad2.members', 'creator'])
              ->where('status', 'WAIT_JOIN')
              ->get();
        
        $jsonizer = new \App\Helpers\Jsonizers\MatchFullJsonizer();
        return $trainings->map(function ($match) use ($jsonizer) {
            return $jsonizer->format($match);
        });
    }
}
