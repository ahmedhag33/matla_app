<?php

namespace App\Jobs\Member;

use App\Mail\Member\SendToMemberVerifcationMail as MailerSendToMemberVerifcationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendToMemberVerifcationMail implements ShouldQueue
{
    use Queueable;
    /**
     * verificationCode
     *
     * @var string
     */
    public string $verificationCode;
    /**
     * email
     *
     * @var string
     */
    public string $email;
    /**
     * Create a new job instance.
     *
     * @param string $verificationCode
     * @return void
     */
    public function __construct($verificationCode, $email)
    {
        $this->verificationCode = $verificationCode;
        // set email
        $this->email = $email;
    }
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)
            ->locale(app()->getLocale())
            ->send(new MailerSendToMemberVerifcationMail($this->verificationCode));
    }
}
