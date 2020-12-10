<?php

use Illuminate\Database\Seeder;
use App\Models\CalendarEvent;
use App\Traits\HolidayList;

class CalendarEventSeeder extends Seeder
{
    use HolidayList;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!CalendarEvent::count()) {
        $data = [];
        array_push($data, ...$this->get_holiday_list());
        CalendarEvent::insert($data);
        }
    }
}
