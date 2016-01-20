<?php

namespace App\Events;

use App\Approval;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ApprovalWasSubmitted extends Event
{
    use SerializesModels;

	public $event;

	/**
	 * Create a new event instance.
	 *
	 * @param Approval $approval
	 * @internal param Request $request
	 */
    public function __construct(Approval $approval)
    {
        $this->event = $approval;
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
