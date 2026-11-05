<?php

namespace App\Listeners\Workspace;

use App\Events\Workspace\ProgramMemberDeleted;
use App\Models\Program;
use App\Models\WorkspaceNotification;

class ProgramMemberDeletedNotify
{
    /**
     * Handle the event.
     */
    public function handle(ProgramMemberDeleted $event): void
    {
        WorkspaceNotification::create([
            'code' => $event->code,
            'member_id' => $event->member_id,
            'workspace_id' => $event->workspace_id,
            'notification_type' => Program::class,
            'notification_id' => $event->program_id,
            'title' => __('Program Member Deleted'),
            'message' => __('You have been removed from the program') . ' ' . $event->program_name,
            'data' => [
                'url' => workspaceURL($event->workspace_slug, ['programs']),
                'photo' => asset('public/img/program.png'), // You can set the member's photo URL here if available
            ],
        ]);
    }
}

