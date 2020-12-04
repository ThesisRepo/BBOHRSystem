<?php

namespace App\Listeners;

use App\Events\NewRequest;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Jobs\NotifyViaGmailJob;
use Carbon\Carbon;

class NotifyViaGmailListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewRequest  $event
     * @return void
     */
    public function handle(NewRequest $event)
    {
        $email = "";
        $username = "";
        if($event->request_type != 'Petty Cash Request' && $event->request_type != 'Budget Request') {
            $email = $event->data->user->assignedPrp->email;
            $username = $event->data->user->assignedPrp->first_name;
        } else {
            $email = $event->data->user->assignedFinance->email;
            $username = $event->data->user->assignedFinance->first_name;
        }
        $job = (new NotifyViaGmailJob($email, 'New Notification from BBO Request Management',  $event->message, $username))->delay(Carbon::now()->addSeconds(2));
          
        dispatch($job);
    }
}
