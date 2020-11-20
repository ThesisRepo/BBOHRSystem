<?php

namespace App\Listeners;

use App\Events\NewRequest;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyViaSlackListener
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
        // slack notification
    }
}
