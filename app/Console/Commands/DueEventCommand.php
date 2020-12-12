<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Events\PublicCalendarEvent;
use App\Events\PrivateCalendarEvent;
use App\Models\CalendarEvent;

class DueEventCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'due:calendar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'triggers event when due';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $calendar = new CalendarEvent();
        foreach($calendar->due_event() as $event) {
            if($event->is_public == 1) {
                // event(new PublicCalendarEvent($event));
            }else {
                event(new PrivateCalendarEvent($event));
                $this->info('calendar events were added to application');
            }  
        }
    }
}
