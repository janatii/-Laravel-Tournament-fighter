<?php

namespace App\Events;

use App\Helpers\Jsonizers\MatchShortJsonizer;
use App\Models\Match;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MatchJoined implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    /**
     * @var \App\Models\Match
     */
    public $match;
    
    /**
     * Create a new event instance.
     *
     * @param \App\Models\Match $match
     */
    public function __construct(Match $match)
    {
        $this->match = $match;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('matchs');
    }
    
    public function broadcastWith()
    {
        return (new MatchShortJsonizer())->format($this->match);
    }
}
