<?php

namespace App\Listeners\Workspace;

use App\Events\Workspace\EpisodeUpdated;
use App\Models\Episode;
use App\Models\WorkspaceNotification;


class EpisodeUpdatedNotify
{
    /**
     * Handle the event.
     */
    public function handle(EpisodeUpdated $event): void
    {
        WorkspaceNotification::create([
            'code' => $event->code,
            'member_id' => $event->member_id,
            'workspace_id' => current_workspace()->id,
            'notification_type' => Episode::class,
            'notification_id' => $event->episode_id,
            'title' => __('Episode Data Updated'),
            'message' => __('Episode Data Updated Number') . '(' . $event->episode_number . ') ' . __('From Program') . ' ' . $event->program_name,
            'data' => [
                'url' => workspaceURL($event->workspace_slug, ['programs', $event->program_slug]),
                'photo' => asset('public/img/program.png'), // You can set the member's photo URL here if available
            ],
        ]);
    }
}
