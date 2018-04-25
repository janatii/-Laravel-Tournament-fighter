<?php

namespace App\Http\Controllers\Front\Trainings;

use App\Models\Match;
use App\Models\Round;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ShowController extends Controller
{
    public function page(Request $request, string $subdomain, Match $match)
    {
        if ($match->status == 'WAIT_JOIN') {
            $request->session()->flash('error-modal', trans('app.front.trainings.show.error-wait-join'));
            return redirect()->to(route_with_subdomain('trainings_main'));
        }
        
        if ($match->status == 'ABORTED') {
            $request->session()->flash('error-modal', trans('app.front.trainings.show.error-aborted'));
            return redirect()->to(route_with_subdomain('trainings_main'));
        }
        
        $match->load('squad1', 'squad1.team', 'squad1.members.games', 'squad2', 'squad2.team', 'squad2.members.games', 'squad1.members.networks', 'squad2.members.networks', 'squad1.manager.networks', 'squad2.manager.networks', 'rounds.match', 'rounds.map', 'rounds.gamemode', 'fullGamemode');
        
        list($mySquadID, $otherSquadID) = $this->getMySquadAndOtherSquadIds($match);
    
        return view('front.trainings.show', compact('match', 'mySquadID', 'otherSquadID'));
    }
    
    public function confirmWager(Request $request, string $subdomain, Match $match)
    {
        $user = Auth::user();
        
        $this->checkMatchWaitConfirm($match);
        
        $validationStatus = $request->input('validation_status');
        
        if ($validationStatus == 'accept') {
            $match->squad1->members()->updateExistingPivot($user->id, ['confirmed' => true]);
            $match->squad2->members()->updateExistingPivot($user->id, ['confirmed' => true]);
            
            $nbNonConfirmed = $match->squad1->notConfirmedMembers()->count();
            $nbNonConfirmed += $match->squad2->notConfirmedMembers()->count();
            
            if ($nbNonConfirmed === 0) {
                $match->launch();
            }
        } elseif ($validationStatus == 'deny') {
            $match->squad1->members()->updateExistingPivot($user->id, ['confirmed' => false]);
            $match->squad2->members()->updateExistingPivot($user->id, ['confirmed' => false]);
            
            $match->abort();
        }
        
        event(new \App\Events\MatchRedirect($match));
        
        return back();
    }
    
    public function sendScoreRound(Request $request, string $subdomain, Match $match, Round $round)
    {
        $user = Auth::user();
        
        $this->checkUserIsManager($match, $user);
    
        $this->checkWinningSquad($request, $match);
    
        $this->checkRoundEndDateIsPast($round);
        
        if ($user->id == $match->squad1->manager_id) {
            if (isset($round->win_squad_sent_by_squad1_id)) {
                abort(403);
            }
            $round->winSquadSentBySquad1()->associate($request->input('winning_squad'));
        } else {
            if (isset($round->win_squad_sent_by_squad2_id)) {
                abort(403);
            }
            $round->winSquadSentBySquad2()->associate($request->input('winning_squad'));
        }
        $round->save();
        
        $this->checkEndMatch($match);
        
        event(new \App\Events\MatchRedirect($match));
        
        return back();
    }
    
    public function arbitrateRound(Request $request, string $subdomain, Match $match, Round $round)
    {
        $user = Auth::user();
        
        $this->checkUserIsRefereeOrAdmin($user);
        
        $this->checkWinningSquad($request, $match);
        
        $round->winSquadSentByReferee()->associate($request->input('winning_squad'));
        $round->referee()->associate($user);
        $round->save();
        
        $this->checkEndMatch($match);
        
        event(new \App\Events\MatchRedirect($match));
        
        return back();
    }
    
    public function askReferee(Request $request, string $subdomain, Match $match)
    {
        if (!$match->wait_referee) {
            $user = Auth::user();
    
            $this->checkMatchIsInProgress($match);
    
            $this->checkUserIsManager($match, $user);
    
            $match->wait_referee = true;
            $match->save();
    
            event(new \App\Events\MatchRedirect($match));
        }
        
        return back();
    }
    
    public function askCancel(Request $request, string $subdomain, Match $match)
    {
        $user = Auth::user();
        
        $this->checkMatchIsInProgress($match);
        
        $this->checkUserIsManager($match, $user);
        
        list($mySquadID, $otherSquadID) = $this->getMySquadAndOtherSquadIds($match);
        
        $match->ask_cancel_squad_id = $mySquadID;
        $match->save();
        
        event(new \App\Events\MatchRedirect($match));
        
        return back();
    }
    
    public function confirmCancel(Request $request, string $subdomain, Match $match)
    {
        $user = Auth::user();
        
        $this->checkMatchIsInProgress($match);
        
        $this->checkUserIsManager($match, $user);
        
        list($mySquadID, $otherSquadID) = $this->getMySquadAndOtherSquadIds($match);
        
        $this->checkCancelWantedByOtherSquad($match, $otherSquadID);
        
        $cancelValidationStatus = $request->input('cancel_validation_status');
    
        $match->ask_cancel_squad_id = null;
        $match->cancel_confirm_user_id = $user->id;
        
        if ($cancelValidationStatus == 'accept') {
            $match->ask_cancel_accepted = true;
            $match->abort();
        } elseif ($cancelValidationStatus == 'deny') {
            $match->ask_cancel_accepted = false;
            $match->save();
        }
        
        event(new \App\Events\MatchRedirect($match));
        
        return back();
    }
    
    public function cancel(Request $request, string $subdomain, Match $match)
    {
        $user = Auth::user();
        
        if ($match->status != 'WAIT_CONFIRM') {
            $this->checkMatchIsInProgress($match);
        
            $this->checkUserIsRefereeOrAdmin($user);
        }
        
        $match->cancel_confirm_user_id = $user->id;
        $match->abort();
        
        event(new \App\Events\MatchRedirect($match));
        
        return back();
    }
    
    /**
     * @param \App\Models\Match $match
     * @param \App\Models\User $user
     */
    private function checkUserIsManager(Match $match, User $user): void
    {
        if ($user->id != $match->squad1->manager_id && $user->id != $match->squad2->manager_id) {
            abort(403);
        }
    }
    
    /**
     * @param \App\Models\Round $round
     */
    private function checkRoundEndDateIsPast(Round $round): void
    {
        if ($round->end_at->gte(\Carbon\Carbon::now())) {
            abort(403);
        }
    }
    
    /**
     * @param \App\Models\User $user
     */
    private function checkUserIsRefereeOrAdmin(User $user): void
    {
        if (!$user->hasAnyRole(['superadmin', 'admin', 'referee'])) {
            abort(403);
        }
    }
    
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Match $match
     */
    private function checkWinningSquad(Request $request, Match $match): void
    {
        $squadsIDs = [$match->squad1_id, $match->squad2_id];
        
        $this->validate($request, [
            'winning_squad' => 'required|in:' . implode(',', $squadsIDs)
        ]);
    }
    
    /**
     * @param \App\Models\Match $match
     */
    private function checkEndMatch(Match $match): void
    {
        $wins = [
            $match->squad1_id => 0,
            $match->squad2_id => 0,
        ];
        foreach ($match->rounds as $round) {
            if (!$round->haveResults()) {
                return;
            }
            $wins[$round->winSquadId()]++;
            if ($wins[$round->winSquadId()] == (round($match->bo / 2.0))) {
                break;
            }
        }
        
        if ($wins[$match->squad1_id] > $wins[$match->squad2_id]) {
            $winSquad = $match->squad1;
            $loseSquad = $match->squad2;
        } else {
            $winSquad = $match->squad2;
            $loseSquad = $match->squad1;
        }
        $match->winSquad()->associate($winSquad);
        
        if ($match->isWager()) {
            foreach ($winSquad->members as $member) {
                if ($member->isPremium()) {
                    $member->addCredits($match, $match->creditsToWinForPremium());
                } else {
                    $member->addCredits($match, $match->creditsToWinForNonPremium());
                }
            }
        }
        
        if ($match->isAffectingElo()) {
            $loseSquadEloAvg = $loseSquad->getEloAverage();
            foreach ($winSquad->members as $member) {
                $member->calculateAndSaveNewElo($match, $loseSquadEloAvg, true);
            }
            $winSquad->team->addScore($match, true);
            
            $winSquadEloAvg = $winSquad->getEloAverage();
            foreach ($loseSquad->members as $member) {
                $member->calculateAndSaveNewElo($match, $winSquadEloAvg, false);
            }
            $loseSquad->team->addScore($match, false);
        }
        
        $match->status = 'FINISH';
        $match->save();
    }
    
    /**
     * @param Match $match
     */
    private function checkMatchWaitConfirm(Match $match): void
    {
        if ($match->status != 'WAIT_CONFIRM') {
            abort(403);
        }
    }
    
    /**
     * @param Match $match
     */
    private function checkMatchIsInProgress(Match $match): void
    {
        if ($match->status != 'IN_PROGRESS') {
            abort(403);
        }
    }
    
    /**
     * @param Match $match
     *
     * @return array
     */
    private function getMySquadAndOtherSquadIds(Match $match): array
    {
        $mySquadID = $otherSquadID = null;
        if ($match->squad1->manager_id == Auth::id() || $match->squad1->members->contains('id', Auth::id())) {
            $mySquadID = $match->squad1_id;
            $otherSquadID = $match->squad2_id;
        } elseif ($match->squad2->manager_id == Auth::id() || $match->squad2->members->contains('id', Auth::id())) {
            $mySquadID = $match->squad2_id;
            $otherSquadID = $match->squad1_id;
        }
        return array($mySquadID, $otherSquadID);
    }
    
    private function checkCancelWantedByOtherSquad(Match $match, int $otherSquadID): void
    {
        if ($match->ask_cancel_squad_id != $otherSquadID) {
            abort(403);
        }
    }
}
