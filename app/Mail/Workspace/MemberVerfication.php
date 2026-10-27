<?php

namespace App\Mail\Workspace;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;

class MemberVerfication extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * The name of the recipient.
     */
    public $name;
    /**
     * The URL for the workspace invitation.
     */
    public $url;
    /**
     * Create a new message instance.
     */
    public function __construct($name, $url)
    {
        // Set the name of the recipient
        $this->name = $name;
        // Set the URL for the workspace invitation
        $this->url = $url;
    }
    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'membership.mail.verification-link',
            with: [
                'name' => $this->name,
                'url' => $this->url,
            ]
        );
    }
}
