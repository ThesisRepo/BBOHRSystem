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
            Role::create(['role_name' => 'emp']);
            Role::create(['role_name' => 'prp emp']);
            Role::create(['role_name' => 'finance mngr']);
            Role::create(['role_name' => 'hr mngr']);
            Role::create(['role_name' => 'general mngr']);         
            Role::create(['role_name' => 'admin']);         
        }     
    }
}
