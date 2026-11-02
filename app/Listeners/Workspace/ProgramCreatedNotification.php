<?php

namespace App\Listeners\Workspace;

use App\Events\Workspace\ProgramCreated;
use App\Models\Program;
use App\Models\WorkspaceNotification;

class ProgramCreatedNotification
{
    /**
     * Handle the event.
     */
    public function handle(ProgramCreated $event): void
    {
        WorkspaceNotification::create([
            'code' => $event->code,
            'member_id' => $event->member_id,
            'workspace_id' => current_workspace()->id,
            'notification_type' => Program::class,
            'notification_id' => $event->program_id,
            'title' => __('New Program Created'),
            'message' =>__('New Program Created').': ' . $event->program_name.' '.__('Created by workspace manager.'),
            'data' => [
                'url' => workspaceURL(['programs', $event->program_slug]),
                'photo' => asset('public/img/program.png'), // You can set the member's photo URL here if available
            ],
        ]);
    }
}
