<?php

namespace App\Providers;

use App\Events\Workspace\NotfiyAcceptToWorkspace;
use App\Events\Workspace\ProgramCreated;
use App\Events\Workspace\ProgramUpdated;
use App\Events\Workspace\ProgramPresenterCreated;
use App\Listeners\Workspace\NotfiyAcceptToWorkspaceListener;
use App\Listeners\Workspace\ProgramCreatedNotification;
use App\Listeners\Workspace\ProgramUpdatedNofiy;
use App\Listeners\Workspace\ProgramPresenterCreatedNotify;
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
        ProgramPresenterCreated::class => [
            ProgramPresenterCreatedNotify::class,
        ],
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
