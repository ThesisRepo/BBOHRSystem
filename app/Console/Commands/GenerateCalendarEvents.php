<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CalendarEvent;
use App\Traits\HolidayList;
use App\Traits\BirthdayList;

class GenerateCalendarEvents extends Command
{
    use HolidayList;

    use BirthdayList;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:calendarEvents';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds official calendar events.';

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
        if(!CalendarEvent::count()) {
            $data = [];
            array_push($data, ...$this->get_holiday_list());
            array_push($data, ...$this->get_birthday_list());
            CalendarEvent::insert($data);
            $this->info('calendar events were added to application');
        }else {
            $this->info('calendar events were already added to application');
        }

    }
}
