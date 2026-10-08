<?php

namespace App\Jobs\Client;

use App\Mail\Client\SendToUserVerifcationCode;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendToUserVerifcationMail implements ShouldQueue
{
    use Queueable;
    /**
     * @var string email
     */
    public string $email;
    /**
     * @var string message
     */
    public string $message;
    /**
     * Create a new job instance.
     *
     * @param string $email
     * @param string $message
     * @return void
     */
    public function __construct(string $email, string $message)
    {
        $this->email = $email;
        $this->message = $message;
    }
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)
            ->locale(app()->getLocale())
            ->send(new SendToUserVerifcationCode($this->message));
    }
}
