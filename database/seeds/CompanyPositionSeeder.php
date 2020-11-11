<?php

use Illuminate\Database\Seeder;
use App\Models\CompanyPosition;
class CompanyPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if( !CompanyPosition::count()) {

            $data = [
                ['position_name' => 'Marketing Staff'],
                ['position_name' => 'Php Developer'],
                ['position_name' => 'Android Developer'],
                ['position_name' => 'Utility/Messenger'],
                ['position_name' => 'Accounting Assistant'],
                ['position_name' => 'Admin'],
                ['position_name' => 'HR'],
                ['position_name' => 'Admin Assistant'],
                ['position_name' => 'Accounting'],
                ['position_name' => 'Online Sales Associate'],
                ['position_name' => 'App Developer'],
                ['position_name' => 'Sales and Support'],
                ['position_name' => 'Marketing Assistant'],
                ['position_name' => 'Reseller Support'],
                ['position_name' => 'Designer']
            ];

            CompanyPosition::insert( $data);
        }
    }
}
