<?php

namespace App\Listeners;

use App\Events\LeadWasAdded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\NewLeadMail;
use Mail;

class SendNewLeadMail implements ShouldQueue
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
     * @param  \App\Events\LeadWasAdded  $event
     * @return void
     */
    public function handle(LeadWasAdded $event)
    {
        $lead = $event->lead;
        $email = new NewLeadMail($lead);
        Mail::to(env('MAIL_USERNAME'))->send($email);
    }
}
