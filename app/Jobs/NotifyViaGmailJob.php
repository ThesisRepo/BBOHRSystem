<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use App\Mail\NotifyViaGmail;
use Mail;


class NotifyViaGmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;

    protected $data;

    protected $subject;

    protected $username;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $subject, $data, $username)
    {
        $this->email = $email;
        $this->subject = $subject;
        $this->data = $data;
        $this->username = $username;


    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new NotifyViaGmail($this->subject, $this->data, $this->username));
    }
}
