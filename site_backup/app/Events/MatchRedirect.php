<?php

namespace App\Events;

use App\Models\Match;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MatchRedirect implements ShouldBroadcast
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
        $userIDs = collect([$this->match->squad1->manager_id, $this->match->squad2->manager_id])
                        ->merge($this->match->squad1->members->pluck('id')->all())
                        ->merge($this->match->squad2->members->pluck('id')->all())
                        ->unique();
        
        $channels = $userIDs->map(function ($item) {
            return new PrivateChannel("user.$item");
        });
        
        return $channels->toArray();
    }
    
    public function broadcastWith()
    {
        return [
            'id' => $this->match->id,
            'url' => route('training_show', [
                'subdomain' => $this->match->game->subdomain,
                'match' => $this->match->id,
            ]),
        ];
    }
}
