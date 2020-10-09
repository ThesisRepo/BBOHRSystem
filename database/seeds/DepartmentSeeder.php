<?php

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!DB::table('departments')->count()) {
            Department::create(['name' => 'Marketing']);
            Department::create(['name' => 'HR']);
            Department::create(['name' => 'Finance']);
            Department::create(['name' => 'Mobile Development']);
            Department::create(['name' => 'Web Development']);
        }  
    }
}
