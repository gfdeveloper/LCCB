<?php

namespace App\Listeners;

use App\Events\CommentWasSubmitted;
use App\Role;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Zizaco\Entrust\EntrustRole;

class SendUpdateEmail
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
     * @param  CommentWasSubmitted  $event
     * @return void
     */
    public function handle(CommentWasSubmitted $event)
    {
        $event->request->load('requester', 'equipment', 'area', 'location', 'category', 'uploads', 'comments');

        $users = User::emailList()->get();

        Mail::send('emails.updated', ['request' => $event->request, 'authUser' => Auth::User()], function ($message) use ($event, $users) {
            $message->from('autobot@lccb.gfoundries.com', 'LCCB Autobot');
            foreach ($users as $user) {
                $message->to($user->email);
            }
            $message->subject('Change Request Updated');
            foreach ($event->request->uploads as $file) {
                $message->attach('D:\www\lccb\uploads\lccbRequests\\' . $file->request_id . '\\' . $file->file_name);
            }
        });
    }
}
