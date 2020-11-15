<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(CompanyPositionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(ShiftTimeSeeder::class);
        $this->call(LeaveTypeSeeder::class);
        $this->call(CompanyStatusSeeder::class);
    }
}
