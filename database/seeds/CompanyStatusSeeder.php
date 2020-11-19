<?php

use Illuminate\Database\Seeder;
use App\Models\CompanyStatus;

class CompanyStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if( !CompanyStatus::count()) {
            CompanyStatus::create(['company_status_name' => 'ojt']);
            CompanyStatus::create(['company_status_name' => 'probitionary']);
            CompanyStatus::create(['company_status_name' => 'regular']);
        }
    }
}
