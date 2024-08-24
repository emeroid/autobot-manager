<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Autobot;

class AutobotCreatedEvent implements ShouldQueue, ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $totalAutobots;
    public $totalComments;
    public $totalPosts;

    public function __construct($totalAutobots, $totalComments, $totalPosts)
    {
        $this->totalAutobots = $totalAutobots;
        $this->totalComments = $totalComments;
        $this->totalPosts = $totalPosts;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('autobots'),
        ];
    }

    // Optionally, you can define a broadcast name
    public function broadcastAs()
    {
        return 'autobot.created'; // Custom event name
    }

    public function broadcastWith()
    {
        return ['autobot' => Autobot::count()];
    }

}
