<?php

namespace App\Events\Workspace;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotifyToMemberTask implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * The ID of the task.
     *
     * @var int
     */
    public int $task_id;
    /**
     * The slug of the task.
     *
     * @var string
     */
    public string $slug;
    /**
     * The code of the task.
     *
     * @var string
     */
    public string $code {
        set {
            $this->code = $value;
        }
        get {
            return $this->code;
        }
    }
    /**
     * The ID of the member who created the task.
     *
     * @var int
     */
    public int $member_id;
    /**
     * The ID of the workspace.
     *
     * @var int
     */
    public int $workspace_id;
    /**
     * The slug of the workspace.
     *
     * @var string
     */
    public string $workspace_slug;
    /**
     * Create a new event instance.
     */
    public function __construct(int $task_id, string $slug, int $member_id, int $workspace_id, string $workspace_slug)
    {
        $this->slug = $slug;
        // Set the code of the task
        $this->code = uniqid();
        // Set the ID of the task
        $this->task_id = $task_id;
        // Set the ID of the member who created the task
        $this->member_id = $member_id;
        // Set the ID of the workspace
        $this->workspace_id = $workspace_id;
        // Set the slug of the workspace
        $this->workspace_slug = $workspace_slug;
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int>
     */
    public function broadcastOn(): array
    {
        return ['notify-to-member-task-' . $this->workspace_id . '-' . $this->member_id];
    }
    /**
     * Get the data to broadcast with the event.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'code' => $this->code,
            'message' => __('Assigned a new task'),
            'title' => __('New Task Created'),
            'date_time' => dateformat(now()) . ' ' . timeFormat(now()),
            'url' => workspaceURL($this->workspace_slug, ['mytasks', '?task=' . $this->slug]),
            'photo' => asset('public/img/list-check-solid.png'), // You can set the member's photo URL here if available
        ];
    }
}
