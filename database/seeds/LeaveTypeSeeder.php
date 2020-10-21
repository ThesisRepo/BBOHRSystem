<?php

use Illuminate\Database\Seeder;
use App\Models\Requests\LeaveType;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!DB::table('leave_types')->count()) {
            LeaveType::create(['leave_type_name' => 'Sick Leave']);
            LeaveType::create(['leave_type_name' => 'Solo Parent Leave']);
            LeaveType::create(['leave_type_name' => 'Vacation Leave']);   
            LeaveType::create(['leave_type_name' => 'Emergency Leave']);
            LeaveType::create(['leave_type_name' => 'Paternity Leave']);
            LeaveType::create(['leave_type_name' => 'Maternity Leave']);   
        }  
    }
}
