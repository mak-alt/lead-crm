<?php

namespace App\Listeners;

use App\Events\MembersAttachedInTeam;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\AssignTeamMembersMail;
use Mail;

class SendAssignMembersToTeamMail implements ShouldQueue
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
     * @param  \App\Events\MembersAttachedInTeam  $event
     * @return void
     */
    public function handle(MembersAttachedInTeam $event)
    {
        $team = $event->team;
        if($team->members->count() > 0){
            foreach($team->members as $member){
                $email = new AssignTeamMembersMail($member, $team);
                Mail::to($member->email)->send($email);
            }
        }
    }
}
