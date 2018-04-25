<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gamemode extends Model
{
    protected $fillable = [
        'name',
    ];
    
    public function game()
    {
        return $this->belongsTo(Game::class);
    }
    
    public function maps()
    {
        return $this->belongsToMany(Map::class, 'maps_gamemodes')->withTimestamps();
    }
    
    public function __toString()
    {
        return $this->name;
    }
}
