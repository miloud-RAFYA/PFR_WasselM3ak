<?php
// app/Events/UserTyping.php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserTyping implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $conversationId;
    public $userName;

    public function __construct($conversationId, $userName)
    {
        $this->conversationId = $conversationId;
        $this->userName = $userName;
    }

    public function broadcastOn()
    {
        return new Channel('chat.' . $this->conversationId);
    }

    public function broadcastAs()
    {
        return 'user.typing';
    }

    public function broadcastWith()
    {
        return [
            'conversationId' => $this->conversationId,
            'userName' => $this->userName,
        ];
    }
}