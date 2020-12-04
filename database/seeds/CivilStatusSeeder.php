<?php

use Illuminate\Database\Seeder;
use App\Models\CivilStatus;

class CivilStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!CivilStatus::count()) {
            CivilStatus::create(['civil_status_name' => 'Single']);
            CivilStatus::create(['civil_status_name' => 'Married']);
            CivilStatus::create(['civil_status_name' => 'Widow']);   
            CivilStatus::create(['civil_status_name' => 'Widower']);  
        }  
    }
}
