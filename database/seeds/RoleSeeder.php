<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
class RoleSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!DB::table('roles')->count()) {
            Role::create(['name' => 'general mngr']);
            Role::create(['name' => 'hr mngr']);
            Role::create(['name' => 'finance mngr']);
            Role::create(['name' => 'prp emp']);
            Role::create(['name' => 'emp']);
        }     
    }
}
