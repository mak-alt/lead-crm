<?php

namespace App\Listeners;

use App\Events\TeamWasAdded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\NewTeamMail;
use Mail;

class SendNewTeamMail implements ShouldQueue
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
     * @param  \App\Events\TeamWasAdded  $event
     * @return void
     */
    public function handle(TeamWasAdded $event)
    {
        $email = new NewTeamMail($event->team);
        Mail::to(env('MAIL_USERNAME'))->send($email);
    }
}
