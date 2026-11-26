<?php

namespace App\Listeners\Workspace;

use App\Events\Workspace\NotifyToMemberTask;
use App\Models\Tasks;
use App\Models\WorkspaceNotification;

class NotifyToMemberTaskListener
{
    /**
     * Handle the event.
     */
    public function handle(NotifyToMemberTask $event): void
    {
        WorkspaceNotification::create([
            'code' => $event->code,
            'member_id' => $event->member_id,
            'workspace_id' => current_workspace()->id,
            'notification_type' => Tasks::class,
            'notification_id' => $event->task_id,
            'title' => __('New Task Created'),
            'message' => __('Assigned a new task'),
            'data' => [
                'url' => workspaceURL($event->workspace_slug, ['mytasks', '?task=' . $event->slug]),
                'photo' => asset('public/img/list-check-solid.png'), // You can set the member's photo URL here if available
            ],
        ]);
    }
}
