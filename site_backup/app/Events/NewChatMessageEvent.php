<?php

namespace App\Events;

use App\Models\ChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewChatMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    /**
     * @var ChatMessage
     */
    private $message;
    
    /**
     * Create a new event instance.
     *
     * @param ChatMessage $message
     */
    public function __construct(ChatMessage $message)
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('match.' . $this->message->match_id);
    }
    
    public function broadcastWith()
    {
        $data = [
            'id' => $this->message->id,
            'message' => $this->message->message,
            'squad_id' => $this->message->squad_id,
            'is_staff' => $this->message->is_staff,
            'is_event' => $this->message->is_event,
            'created_at' => $this->message->created_at,
        ];
        if ($this->message->user_id) {
            $data['user'] = [
                'id' => $this->message->user_id,
                'username' => $this->message->user->username,
            ];
        }
        return $data;
    }
}
