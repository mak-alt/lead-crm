<?php

namespace App\Listeners;

use App\Events\TaskWasAdded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\NewTaskMail;
use Mail;

class SendNewTaskMail implements ShouldQueue
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
     * @param  \App\Events\TaskWasAdded  $event
     * @return void
     */
    public function handle(TaskWasAdded $event)
    {
        $task = $event->task;
        $email = new NewTaskMail($task);
        Mail::to(env('MAIL_USERNAME'))->send($email);
    }
}
