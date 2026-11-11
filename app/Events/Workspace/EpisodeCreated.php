<?php

namespace App\Events\Workspace;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EpisodeCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * The ID of the program that was created.
     *
     * @var int
     */
    public int $episode_id;
    /**
     * The program that was created.
     *
     * @var string
     */
    public string $program_name;
    /**
     * The slug of the program.
     *
     * @var string
     */
    public string $program_slug;
    /**
     * The unique slug of the episode.
     *
     * @var string
     */
    public string $episode_slug;
    /**
     * The title of the episode.
     *
     * @var string
     */
    public string $episode_title;
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
        int $episode_id,
        string $program_name,
        string $program_slug,
        string $episode_slug,
        string $episode_title,
        int $member_id,
        int $workspace_id,
        string $workspace_slug
    ) {
        $this->episode_id = $episode_id;
        // Assign the episode ID to the class property
        $this->program_name = $program_name;
        // Assign the program slug to the class property
        $this->program_slug = $program_slug;
        // Assign the episode slug to the class property
        $this->episode_slug = $episode_slug;
        // Assign the episode title to the class property
        $this->episode_title = $episode_title;
        // Assign the member ID to the class property
        $this->member_id = $member_id;
        // Assign the workspace ID to the class property
        $this->workspace_id = $workspace_id;
        // Assign the workspace slug to the class property
        $this->workspace_slug = $workspace_slug;
        // Assign the code to the class property
        $this->code = uniqid();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int>
     */
    public function broadcastOn(): array
    {
        return ['episode-created-' . $this->workspace_id . '-' . $this->member_id];
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
            'message' => __('New Episode Created Under') . ': ' . $this->episode_title . ' ' . __('From Program') . ' ' . $this->program_name,
            'title' => __('New Episode Created'),
            'date_time' => dateformat(now()) . ' ' . timeFormat(now()),
            'url' => workspaceURL($this->workspace_slug, ['programs', $this->program_slug]),
            'photo' => asset('public/img/program.png'), // You can set the member's photo URL here if available
        ];
    }
}
