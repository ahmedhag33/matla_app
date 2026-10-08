<?php

namespace App\Mail\Client;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendToUserVerifcationCode extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var string text
     */
    public string $text;
    /**
     * Create a new message instance.
     */
    public function __construct(string $text)
    {
        $this->text = $text;
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Send To User Verifcation Code',
        );
    }
    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'client.mail.send-to-user-verification-code',
        );
    }
}
