<?php

namespace App\Mail\Member;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendToMemberVerifcationMail extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * The order instance.
     *
     * @var mixed
     */
    public $verificationCode;
    /**
     * Create a new message instance.
     */
    public function __construct($verificationCode)
    {
        $this->verificationCode = $verificationCode;
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Send To Member Verifcation Mail',
        );
    }
    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'membership.mail.verfication',
        );
    }
}
