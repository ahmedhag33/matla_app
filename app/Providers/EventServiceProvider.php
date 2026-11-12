<?php

namespace App\Providers;

use App\Events\Workspace\EpisodeCreated;
use App\Events\Workspace\EpisodeUpdated;
use App\Events\Workspace\NotfiyAcceptToWorkspace;
use App\Events\Workspace\ProgramCreated;
use App\Events\Workspace\ProgramMemberCreated;
use App\Events\Workspace\ProgramMemberDeleted;
use App\Events\Workspace\ProgramUpdated;
use App\Listeners\Workspace\EpisodeCreatedNotfiy;
use App\Listeners\Workspace\EpisodeUpdatedNotify;
use App\Listeners\Workspace\NotfiyAcceptToWorkspaceListener;
use App\Listeners\Workspace\ProgramCreatedNotification;
use App\Listeners\Workspace\ProgramMemberCreatedNotify;
use App\Listeners\Workspace\ProgramMemberDeletedNotify;
use App\Listeners\Workspace\ProgramUpdatedNofiy;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        NotfiyAcceptToWorkspace::class => [
            NotfiyAcceptToWorkspaceListener::class,
        ],
        ProgramCreated::class => [
            ProgramCreatedNotification::class,
        ],
        ProgramUpdated::class => [
            ProgramUpdatedNofiy::class,
        ],
        ProgramMemberCreated::class => [
            ProgramMemberCreatedNotify::class,
        ],
        ProgramMemberDeleted::class => [
            ProgramMemberDeletedNotify::class,
        ],
        EpisodeCreated::class => [
            EpisodeCreatedNotfiy::class,
        ],
        EpisodeUpdated::class => [
            EpisodeUpdatedNotify::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
