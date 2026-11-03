<?php

namespace App\Listeners\Workspace;

use App\Events\Workspace\ProgramUpdated;
use App\Models\Program;
use App\Models\WorkspaceNotification;

class ProgramUpdatedNofiy
{
    /**
     * Handle the event.
     */
    public function handle(ProgramUpdated $event): void
    {
        WorkspaceNotification::create([
            'code' => $event->code,
            'member_id' => $event->member_id,
            'workspace_id' => current_workspace()->id,
            'notification_type' => Program::class,
            'notification_id' => $event->program_id,
            'title' => __('New Program Created'),
            'message' => $event->message . ' ' . __('From') . ' ' . $event->old . ' ' . __('To') . ' ' . $event->new,
            'data' => [
                'url' => workspaceURL($event->workspace_slug, ['programs', $event->program_slug]),
                'photo' => asset('public/img/program.png'), // You can set the member's photo URL here if available
            ],
        ]);
    }
}
