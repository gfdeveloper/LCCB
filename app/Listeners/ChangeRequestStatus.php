<?php

namespace App\Listeners;

use App\Approval;
use App\Events\ApprovalWasSubmitted;
use App\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ChangeRequestStatus
{
	public $request;

	public $count;

	/**
	 * Create the event listener.
	 *
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param ApprovalWasSubmitted $approval
	 * @internal param ApprovalWasSubmitted $event
	 */
	public function handle(ApprovalWasSubmitted $approval)
	{
		$this->request = Request::find($approval->request_id)->get();

	}
}
