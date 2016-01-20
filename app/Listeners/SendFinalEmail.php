<?php

namespace App\Listeners;

use App\Approval;
use App\Events\FinalStatusSubmitted;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SendFinalEmail
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
     * @param  FinalStatusSubmitted  $event
     * @return void
     */
    public function handle(FinalStatusSubmitted $event)
    {
        $event->request->load('requester', 'equipment', 'area', 'location', 'category', 'uploads', 'comments');
        $users = User::emailList()->get();

        Mail::send('emails.finished', ['request' => $event->request, 'approvers' => Approval::getRecent($event->request->id)], function ($message) use ($event, $users) {
            $message->from('autobot@lccb.gfoundries.com', 'LCCB Autobot');
            foreach ($users as $user) {
                $message->to($user->email);
            }
            $message->subject('Change Request Closed');
            foreach ($event->request->uploads as $file) {
                $message->attach('D:\www\lccb\uploads\lccbRequests\\' . $file->request_id . '\\' . $file->file_name);
            }
        });
    }
}
