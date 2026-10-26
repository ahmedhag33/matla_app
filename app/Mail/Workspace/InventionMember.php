<?php

namespace App\Mail\Workspace;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;

class InventionMember extends Mailable
{
    use Queueable, SerializesModels;
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
    public function __construct($name, $workspaceName, $url)
    {
        // Set the name of the recipient
        $this->name = $name;
        // Set the workspace name
        $this->workspaceName = $workspaceName;
        // Set the URL for the workspace invitation
        $this->url = $url;
    }
    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'workspace.mail.invention',
            with: [
                'name' => $this->name,
                'workspaceName' => $this->workspaceName,
                'url' => $this->url,
            ]
        );
    }
}
