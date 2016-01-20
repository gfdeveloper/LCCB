<?php

namespace App\Listeners;

use App\Approval;
use App\Events\ActionItemApproved;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SendEmailToToolInstallLayoutOrg
{
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
     * @param  ActionItemApproved  $event
     * @return void
     */
    public function handle(ActionItemApproved $event)
    {
        $event->request->load('requester', 'equipment', 'area', 'location', 'category', 'uploads', 'comments');
        $users = User::toolInstallLayoutEmails()->get();

        Mail::send('emails.toolInstallLayoutApproved', ['request' => $event->request, 'approvers' => Approval::getRecent($event->request->id)], function ($message) use ($event, $users) {
            $message->from('autobot@lccb.gfoundries.com', 'LCCB Autobot');
            foreach ($users as $user) {
                $message->to($user->email);
            }
            $message->subject('Change Request Approved');
            foreach ($event->request->uploads as $file) {
                $message->attach('D:\www\lccb\uploads\lccbRequests\\' . $file->request_id . '\\' . $file->file_name);
            }
        });
    }
}
