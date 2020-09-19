<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Role;
class CreateHrManAcc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:hr-manager-acc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command creates default finance manager acc.' .
    'If a hr account already existed then it won\'t generate a new account';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $password = bcrypt('123456789');
        $user = new User(['name'=>'marionon','email'=>'ma@gmail.com','password'=> $password]);
        $role = Role::find(2); 
        $role = $role->users()->save($user).info('hr manager account created successfully');
        
    }
}
