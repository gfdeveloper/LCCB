<?php

namespace App\Listeners;

use App\Events\RequestWasSubmitted;
use App\Role;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SendThankYouEmail
{
	/**
	 * Create the event listener.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param  RequestWasSubmitted $event
	 * @return void
	 */
	public function handle(RequestWasSubmitted $event)
	{
		$event->request->load('requester', 'equipment', 'area', 'location', 'category', 'uploads');

		$users = User::emailList()->get();

		Mail::send('emails.submitted', ['request' => $event->request], function ($message) use ($event, $users) {
			$message->from('autobot@lccb.gfoundries.com', 'LCCB Autobot');
			foreach ($users as $user) {
				$message->to($user->email);
			}
			$message->to(Auth::user()->email);
			$message->subject('New Change Request Submitted');
			foreach ($event->request->uploads as $file) {
				$message->attach('D:\www\lccb\uploads\lccbRequests\\' . $file->request_id . '\\' . $file->file_name);
			}
		});
	}
}
