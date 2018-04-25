<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    public $table = 'chat_messages';
    
    public $guarded = [];
    
    public function match()
    {
        return $this->belongsTo(Match::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function squad()
    {
        return $this->belongsTo(Squad::class);
    }
}
