<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Squad extends Model
{
    public function manager()
    {
        return $this->belongsTo(User::class);
    }
    
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
    
    public function members()
    {
        return $this->belongsToMany(User::class, 'squads_members')->withPivot(['confirmed']);
    }
    
    public function notConfirmedMembers()
    {
        return $this->members()->wherePivot('confirmed', false);
    }
    
    public function match()
    {
        return $this->belongsTo(Match::class);
    }
    
    public function matchCreated()
    {
        return $this->hasOne(Match::class, 'squad1_id');
    }
    
    public function matchJoined()
    {
        return $this->hasOne(Match::class, 'squad2_id');
    }
    
    public function getEloAverage()
    {
        return (int)round(
            DB::table('game_infos')
              ->join('squads_members', 'squads_members.user_id', 'game_infos.user_id')
              ->where('squads_members.squad_id', $this->id)
              ->avg(DB::raw('game_infos.score'))
        );
    }
}
