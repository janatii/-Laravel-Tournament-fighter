<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Match extends Model
{
    public function game()
    {
        return $this->belongsTo(Game::class);
    }
    
    public function fullGamemode()
    {
        return $this->belongsTo(Gamemode::class);
    }
    
    public function creator()
    {
        return $this->belongsTo(User::class);
    }
    
    public function squad1()
    {
        return $this->belongsTo(Squad::class);
    }
    
    public function squad2()
    {
        return $this->belongsTo(Squad::class);
    }
    
    public function winSquad()
    {
        return $this->belongsTo(Squad::class);
    }
    
    public function rounds()
    {
        return $this->hasMany(Round::class);
    }
    
    public function cancelConfirmUser()
    {
        return $this->belongsTo(User::class);
    }
    
    public function creditsToWinForPremium()
    {
        return $this->bet * 2;
    }
    
    public function creditsToWinForNonPremium()
    {
        return round($this->bet * 2 * 0.8);
    }
    
    public function managers()
    {
        return DB::table('users')
                 ->join('squads', 'manager_id', '=', 'users.id')
                 ->join('matches', function (\Illuminate\Database\Query\JoinClause $join) {
                    $join->on('matches.squad1_id', '=', 'squads.id')
                         ->orOn('matches.squad2_id', '=', 'squads.id');
                 })
                 ->where('matches.id', $this->id)
                 ->select('users.*');
    }
    
    public function getManagersAttribute()
    {
        return $this->managers()
                    ->get()
                    ->map(function ($item) {
                        return (new User())->forceFill((array)$item);
                    });
    }
    
    public function members()
    {
        return DB::table('users')
                 ->join('squads_members', 'user_id', '=', 'users.id')
                 ->join('matches', function (\Illuminate\Database\Query\JoinClause $join) {
                    $join->on('matches.squad1_id', '=', 'squads_members.squad_id')
                         ->orOn('matches.squad2_id', '=', 'squads_members.squad_id');
                 })
                 ->where('matches.id', $this->id)
                 ->select('users.*');
    }
    
    public function getMembersAttribute()
    {
        return $this->members()
                    ->get()
                    ->map(function ($item) {
                        return (new User())->forceFill((array)$item);
                    });
    }
    
    public function concernedUsers()
    {
        return $this->managers()->union($this->members());
    }
    
    public function getConcernedUsersAttribute()
    {
        return $this->concernedUsers()
                    ->get()
                    ->map(function ($item) {
                        return (new User())->forceFill((array)$item);
                    });
    }
    
    public function launch()
    {
        if ($this->type == 'WAGER') {
            foreach ($this->squad1->members as $member) {
                $member->removeCredits($this, $this->bet);
            }
            foreach ($this->squad2->members as $member) {
                $member->removeCredits($this, $this->bet);
            }
        }
        
        $this->status = 'IN_PROGRESS';
        $this->initRoundsCountdowns();
        $this->save();
    }
    
    public function abort()
    {
        // Refund all players
        if ($this->status == 'IN_PROGRESS' && $this->type == 'WAGER') {
            foreach ($this->squad1->members as $member) {
                $member->credits += $this->bet;
                $member->save();
            }
            foreach ($this->squad2->members as $member) {
                $member->credits += $this->bet;
                $member->save();
            }
        }
        
        $this->status = 'ABORTED';
        $this->resetRoundsCountdowns();
        $this->save();
    }
    
    public function initRoundsCountdowns()
    {
        $minutesByRound = $this->game->time_per_round;
        $nextRoundDate = Carbon::now()->addMinutes($minutesByRound);
        foreach ($this->rounds as $round) {
            $round->end_at = $nextRoundDate;
            $round->save();
            
            $nextRoundDate = $nextRoundDate->addMinutes($minutesByRound);
        }
    }
    
    public function resetRoundsCountdowns()
    {
        foreach ($this->rounds as $round) {
            $round->end_at = null;
            $round->save();
        }
    }
    
    public function isWaitingConfirmation()
    {
        return $this->status == 'WAIT_CONFIRM';
    }
    
    public function isInProgress()
    {
        return $this->status == 'IN_PROGRESS';
    }
    
    public function isWager()
    {
        return $this->type == 'WAGER';
    }
    
    public function isRanked()
    {
        return $this->type == 'RANKED';
    }
    
    public function isFriendly()
    {
        return $this->type == 'FRIENDLY';
    }
    
    public function isAffectingElo()
    {
        return $this->isWager() || $this->isRanked();
    }
}
