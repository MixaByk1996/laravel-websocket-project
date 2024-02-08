<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StoreAnswerEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $answer;

    /**
     * Create a new event instance.
     */
    public function __construct($answer)
    {
        //
        $this->answer = $answer;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('store_answer_' . $this->answer->user_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'store_answer';
    }

    public function broadcastWith(): array
    {
        return [
            'answer' => $this->answer
        ];
    }
}
