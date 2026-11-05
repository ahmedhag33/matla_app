<?php

namespace App\Events\Workspace;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProgramMemberCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $program_id;
    public string $program_name;
    public string $program_slug;
    public string $code;
    public int $member_id;
    public int $workspace_id;
    public string $workspace_slug;

    public function __construct(
        int $program_id,
        string $program_name,
        string $program_slug,
        int $member_id,
        int $workspace_id,
        string $workspace_slug
    ) {
        $this->program_id = $program_id;
        $this->program_name = $program_name;
        $this->program_slug = $program_slug;
        $this->code = uniqid();
        $this->member_id = $member_id;
        $this->workspace_id = $workspace_id;
        $this->workspace_slug = $workspace_slug;
    }

    public function broadcastOn(): array
    {
        return ['program-member-created-' . $this->workspace_id . '-' . $this->member_id];
    }

    public function broadcastWith(): array
    {
        return [
            'code' => $this->code,
            'message' => __('You have been added as a program presenter to') . ' ' . $this->program_name,
            'title' => __('New Program Created'),
            'date_time' => dateformat(now()) . ' ' . timeFormat(now()),
            'url' => workspaceURL($this->workspace_slug, ['programs', $this->program_slug]),
            'photo' => asset('public/img/program.png'),
        ];
    }
}
