<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\NewRegistrationMail;
use App\Events\UserWasRegistered;
use Mail;

class SendRegistrationMail implements ShouldQueue
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(UserWasRegistered $event)
    {
        $user = $event->user;
        $email = new NewRegistrationMail($user);
        Mail::to($user->email)->send($email);
    }
}
