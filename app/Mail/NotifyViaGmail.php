<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyViaGmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $message;
    
    public $subject;

    public $username;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $message, $username)
    {
        $this->message = $message;
        $this->subject = $subject;
        $this->username = $username;

        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)->markdown('emails.requests-email-notification')->with($this->message, $this->username);
    }
}
