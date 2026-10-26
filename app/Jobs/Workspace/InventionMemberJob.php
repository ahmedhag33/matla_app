<?php

namespace App\Jobs\Workspace;

use App\Mail\Workspace\InventionMember;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class InventionMemberJob implements ShouldQueue
{
    use Queueable;
    /**
     * The email of the recipient.
     */
    public $email;
    /**
     * The name of the recipient.
     */
    public $name;
    /**
     * The name of the workspace.
     */
    public $workspaceName;
    /**
     * The URL for the workspace invitation.
     */
    public $url;
    /**
     * Create a new message instance.
     */
    public function __construct($email, $name, $workspaceName, $url)
    {
        // Set the email of the recipient
        $this->email = $email;
        // Set the name of the recipient
        $this->name = $name;
        // Set the workspace name
        $this->workspaceName = $workspaceName;
        // Set the URL for the workspace invitation
        $this->url = $url;
    }
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)
            ->locale(app()->getLocale())
            ->send(new InventionMember($this->name, $this->workspaceName, $this->url));
    }
}
