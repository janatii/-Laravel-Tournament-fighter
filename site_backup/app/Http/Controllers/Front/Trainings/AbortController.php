<?php

namespace App\Http\Controllers\Front\Trainings;

use App\Models\Match;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AbortController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function abort(Request $request)
    {
        $user = Auth::user();
        
        /** @var Match $match */
        $match = Match::findOrFail($request->input('match'))->load(['game', 'creator']);
        if ($match->creator->id != $user->id) {
            abort(403);
        }
        if ($match->status != 'WAIT_JOIN' && $match->status != 'WAIT_CONFIRM') {
            abort(403);
        }
        
        event(new \App\Events\MatchAborted($match));
        
        $match->status = 'ABORTED';
        $match->save();
        
        return response()->json(['message' => 'Match aborted !']);
    }
}
