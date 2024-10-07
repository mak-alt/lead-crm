<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Models\{
    Lead ,  
    Team,
    Task,
    User
};
use App\Observers\{
    LeadObserver,
    TeamObserver,
    TaskObserver,
    UserObserver
};
use App\Events\{
    UserWasRegistered,
    RegistrationWillComplete,
    LeadWasAdded,
    TeamWasAdded,
    MembersAttachedInTeam,
    TaskWasAdded,
    MembersAttachedInTask
};
use App\Listeners\{
    SendRegistrationMail,
    SendCompleteRegistrationMail,
    SendNewLeadMail,
    SendNewTeamMail,
    SendAssignMembersToTeamMail,
    SendNewTaskMail,
    SendAssignMembersToTaskMail
};

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        UserWasRegistered::class => [
            SendRegistrationMail::class,
        ],

        RegistrationWillComplete::class => [
            SendCompleteRegistrationMail::class,
        ],

        LeadWasAdded::class => [
            SendNewLeadMail::class,
        ],

        TeamWasAdded::class => [
            SendNewTeamMail::class,
        ],

        MembersAttachedInTeam::class => [
            SendAssignMembersToTeamMail::class,
        ],

        TaskWasAdded::class => [
            SendNewTaskMail::class,
        ],

        MembersAttachedInTask::class => [
            SendAssignMembersToTaskMail::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Lead::observe(LeadObserver::class);
        Team::observe(TeamObserver::class);
        Task::observe(TaskObserver::class);
        User::observe(UserObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
