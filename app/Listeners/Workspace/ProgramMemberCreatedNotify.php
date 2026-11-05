<?php

namespace App\Listeners\Workspace;
use App\Models\Program;

use App\Models\WorkspaceNotification;
use App\Events\Workspace\ProgramMemberCreated;
class ProgramMemberCreatedNotify
{
    /**
     * Handle the event.
     */
    public function handle(ProgramMemberCreated $event): void
    {
        WorkspaceNotification::create([
            'code' => $event->code,
            'member_id' => $event->member_id,
            'workspace_id' => $event->workspace_id,
            'notification_type' => Program::class,
            'notification_id' => $event->program_id,
            'title' => __('New Program Created'),
            'message' => __('You have been added as a program presenter to') . ' ' . $event->program_name,
            'data' => [
                'url' => workspaceURL($event->workspace_slug, ['programs', $event->program_slug]),
                'photo' => asset('public/img/program.png'), // You can set the member's photo URL here if available
            ],
        ]);
    }
}
