<?php

use Illuminate\Database\Seeder;
use App\Models\Requests\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!DB::table('status')->count()) {
            Status::create(['status_name' => 'pending']);
            Status::create(['status_name' => 'approved']);
            Status::create(['status_name' => 'disapproved']);    
        }  
    }
}
