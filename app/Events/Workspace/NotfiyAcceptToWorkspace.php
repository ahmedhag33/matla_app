<?php

namespace App\Events\Workspace;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotfiyAcceptToWorkspace implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * The ID of the workspace.
     *
     * @var int
     */
    public int $workspaceId;
    /**
     * The ID of the user who accepted the workspace invitation.
     *
     * @var int
     */
    public int $memberId;
    /**
     * The ID of the workspace member.
     *
     * @var int
     */
    public int $workspaceMemberId;
    /**
     * The ID of the user who accepted the workspace invitation.
     *
     * @var string
     */
    public string $memberName;
    /**
     * The URL associated with the notification.
     *
     * @var string
     */
    public string $url;
    /**
     * Create a new event instance.
     *
     * @param int $workspaceId
     * @param int $memberId The ID of the user who accepted the workspace invitation.
     * @param int $workspaceMemberId The ID of the workspace member.
     * @param string $memberName The name of the user who accepted the workspace invitation.
     * @return void
     */
    public function __construct(int $workspaceId, int $memberId, int $workspaceMemberId, string $memberName, string $url)
    {
        $this->workspaceId = $workspaceId;
        // Set the member ID
        $this->memberId = $memberId;
        // Set the workspace member ID
        $this->workspaceMemberId = $workspaceMemberId;
        // Set the member name
        $this->memberName = $memberName;
        // Set the URL
        $this->url = $url;
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int>
     */
    public function broadcastOn(): array
    {
        return ['workspace-notify-accept-' . $this->workspaceId . '-' . $this->memberId];
    }
    /**
     * Get the data to broadcast with the event.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'message' => __('Invitation Accepted') . ' ' . $this->memberName,
            'title' => __('New Member'),
            'date_time' => dateformat(now()) . ' ' . timeFormat(now()),
            'url' => $this->url,
            'photo' => asset('public/img/usersolidfull.svg'), // You can set the member's photo URL here if available
            'member_name' => $this->memberName,
            'workspace_id' => $this->workspaceId,
            'member_id' => $this->memberId,
            'workspace_member_id' => $this->workspaceMemberId
        ];
    }
}
