<?php

namespace App\Listeners;

use App\Events\MembersAttachedInTask;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\AssignTaskMembersMail;
use Mail;

class SendAssignMembersToTaskMail implements ShouldQueue
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
     * @param  \App\Events\MembersAttachedInTask  $event
     * @return void
     */
    public function handle(MembersAttachedInTask $event)
    {
        $members = $event->members;
        $task = $event->task;
        if($members->count() > 0){
            foreach($members as $member){
                $email = new AssignTaskMembersMail($member, $task);
                Mail::to($member->email)->send($email);
            }
        }
    }
}
