<?php

use Illuminate\Database\Seeder;
use App\Models\Requests\ShiftTime;

class ShiftTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!DB::table('shift_times')->count()) {
            ShiftTime::create(['shift_time_name' => '8am-5pm']);
            ShiftTime::create(['shift_time_name' => '9am-6pm']);
            ShiftTime::create(['shift_time_name' => '10am-7pm']);
            ShiftTime::create(['shift_time_name' => '2pm-11pm']);    
        }  
    }
}
