<?php

namespace App\Events\Workspace;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProgramUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * The ID of the program that was created.
     *
     * @var int
     */
    public int $program_id;
    /**
     * The message for the program update.
     *
     * @var string
     */
    public string $message;
    /**
     * The program that was created.
     *
     * @var string
     */
    public string $old;
    /**
     * The new program name.
     *
     * @var string
     */
    public string $new;
    /**
     * The slug of the program.
     *
     * @var string
     */
    public string $program_slug;
    /**
     * The code of the program.
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
     * The ID of the member who created the program.
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
    public function __construct(
        int $program_id,
        string $message,
        string $old,
        string $new,
        string $program_slug,
        int $member_id,
        int $workspace_id,
        string $workspace_slug
    ) {
        $this->program_id = $program_id;
        // Set the old program name
        $this->old = $old;
        // Set the new program name
        $this->new = $new;
        // Set the program slug
        $this->program_slug = $program_slug;
        // Set the program code
        $this->code = uniqid();
        // Set the member ID
        $this->member_id = $member_id;
        // Set the workspace ID
        $this->workspace_id = $workspace_id;

        $this->workspace_slug = $workspace_slug;
        $this->message = $message;
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int>
     */
    public function broadcastOn(): array
    {
        return ['program-updated-' . $this->workspace_id . '-' . $this->member_id];
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
            'message' => $this->message . ' ' . __('From') . ' ' . $this->old . ' ' . __('To') . ' ' . $this->new,
            'title' => __('Program Updated'),
            'date_time' => dateformat(now()) . ' ' . timeFormat(now()),
            'url' => workspaceURL($this->workspace_slug, ['programs', $this->program_slug]),
            'photo' => asset('public/img/program.png'), // You can set the member's photo URL here if available
        ];
    }
}
