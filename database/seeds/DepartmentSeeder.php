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
            Department::create(['department_name' => 'Marketing']); // 1
            Department::create(['department_name' => 'Admin']); // 2
            Department::create(['department_name' => 'Finance']); // 3
            Department::create(['department_name' => 'CS(Sales)']); // 4
            Department::create(['department_name' => 'Mobile Development']); // 5
            Department::create(['department_name' => 'Web Development']); // 6
        }  
    }
}
