<?php

namespace App\Listeners;

use App\Events\ActionItemSubmitted;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SendNewActionItemEmail
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
     * @param  ActionItemSubmitted  $event
     * @return void
     */
    public function handle(ActionItemSubmitted $event)
    {
        $event->action->load('submitted');
        $users = User::emailList()->get();

        Mail::send('emails.actionItemCreated', ['item' => $event->action], function ($message) use ($event, $users) {
            $message->from('autobot@lccb.gfoundries.com', 'LCCB Autobot');
            foreach ($users as $user) {
                $message->to($user->email);
            }
            $message->to(Auth::user()->email);
            $message->subject('New Action Item Submitted');
        });
    }
}
