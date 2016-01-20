<?php

namespace App\Events;

use App\Actions;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ActionItemSubmitted extends Event
{
    use SerializesModels;

    public $action;

    /**
     * Create a new event instance.
     *
     * @param Actions $action
     * @internal param Actions $item
     */
    public function __construct(Actions $action)
    {
        $this->action = $action;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
