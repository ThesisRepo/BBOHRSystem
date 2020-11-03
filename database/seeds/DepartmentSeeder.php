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
            Department::create(['department_name' => 'Marketing']);
            Department::create(['department_name' => 'Admin']);
            Department::create(['department_name' => 'Finance']);
            Department::create(['department_name' => 'Mobile Development']);
            Department::create(['department_name' => 'Web Development']);
        }  
    }
}
