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
                ['position_name' => 'Marketing Staff'], // 1
                ['position_name' => 'Php Developer'], // 2
                ['position_name' => 'Android Developer'], // 3
                ['position_name' => 'Utility/Messenger'], // 4
                ['position_name' => 'Accounting Assistant'], // 5
                ['position_name' => 'Admin'], // 6
                ['position_name' => 'HR'], // 7
                ['position_name' => 'Admin Assistant'], // 8
                ['position_name' => 'Accounting'], // 9
                ['position_name' => 'Online Sales Associate'], // 10
                ['position_name' => 'App Developer'], // 11
                ['position_name' => 'Sales and Support'], // 12
                ['position_name' => 'Marketing Assistant'], // 13
                ['position_name' => 'Reseller Support'], // 14
                ['position_name' => 'Designer'], // 15
                ['position_name' => 'General Manager'], // 16
                ['position_name' => 'Customer Support Leader'], // 17

            ];

            CompanyPosition::insert( $data);
        }
    }
}
