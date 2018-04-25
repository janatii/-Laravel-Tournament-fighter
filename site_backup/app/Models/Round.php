<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
        'end_at',
    ];
    
    public function map()
    {
        return $this->belongsTo(Map::class);
    }
    
    public function gamemode()
    {
        return $this->belongsTo(Gamemode::class);
    }
    
    public function match()
    {
        return $this->belongsTo(Match::class);
    }
    
    public function referee()
    {
        return $this->belongsTo(User::class);
    }
    
    public function winSquadSentBySquad1()
    {
        return $this->belongsTo(Squad::class);
    }
    
    public function winSquadSentBySquad2()
    {
        return $this->belongsTo(Squad::class);
    }
    
    public function winSquadSentByReferee()
    {
        return $this->belongsTo(Squad::class);
    }
    
    public function wasWinBySquad1()
    {
        return $this->winSquadId() == $this->match->squad1_id;
    }
    
    public function wasWinBySquad2()
    {
        return $this->winSquadId() == $this->match->squad2_id;
    }
    
    public function haveResults()
    {
        return $this->winSquadId() != null;
    }
    
    public function winSquadId()
    {
        if ($this->allResultsSent()) {
            if ($this->needReferee() || isset($this->win_squad_sent_by_referee_id)) {
                return $this->win_squad_sent_by_referee_id;
            } else {
                return $this->win_squad_sent_by_squad1_id;
            }
        }
        return null;
    }
    
    public function needReferee()
    {
        return $this->allResultsSent() && $this->resultsSentAreDifferent() && !isset($this->win_squad_sent_by_referee_id);
    }
    
    public function resultsSentAreDifferent()
    {
        return $this->win_squad_sent_by_squad1_id != $this->win_squad_sent_by_squad2_id;
    }
    
    public function allResultsSent()
    {
        return (isset($this->win_squad_sent_by_squad1_id) && isset($this->win_squad_sent_by_squad2_id)) || isset($this->win_squad_sent_by_referee_id);
    }
}
