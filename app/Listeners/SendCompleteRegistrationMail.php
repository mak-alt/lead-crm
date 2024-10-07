<?php

namespace App\Listeners;

use App\Events\RegistrationWillComplete;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\CompleteRegistrationMail;
use Mail;

class SendCompleteRegistrationMail implements ShouldQueue
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
     * @param  \App\Events\RegistrationWillComplete  $event
     * @return void
     */
    public function handle(RegistrationWillComplete $event)
    {
        $user = $event->user;
        $email = new CompleteRegistrationMail($user);
        Mail::to($user->email)->send($email);
    }
}
