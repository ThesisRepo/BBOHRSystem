<?php

use Illuminate\Database\Seeder;
use App\Models\Civilstatus;

class CivilStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!Civilstatus::count()) {
            Civilstatus::create(['civil_status_name' => 'Single']);
            Civilstatus::create(['civil_status_name' => 'Married']);
            Civilstatus::create(['civil_status_name' => 'Widow']);   
            Civilstatus::create(['civil_status_name' => 'Widower']);  
        }  
    }
}
