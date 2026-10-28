<?php

namespace App\Listeners\Workspace;

use App\Events\Workspace\NotfiyAcceptToWorkspace;
use App\Models\WorkspaceMembers;
use App\Models\WorkspaceNotification;

class NotfiyAcceptToWorkspaceListener
{
    /**
     * Handle the event.
     */
    public function handle(NotfiyAcceptToWorkspace $event): void
    {
        WorkspaceNotification::create([
            'member_id' => $event->memberId,
            'workspace_id' => $event->workspaceId,
            'notification_type' => WorkspaceMembers::class,
            'notification_id' => $event->workspaceMemberId,
            'title' => __('New Member'),
            'message' => __('Invitation Accepted') . ' ' . $event->memberName,
            'data' => [
                'url' => $event->url,
                'photo' => asset('public/img/user-solid-full.svg'), // You can set the member's photo URL here if available
            ],
        ]);
    }
}
