<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Eloquent\Implementations\UserEloquent;
use App\Models\User;
use App\Traits\CommandValidation;
use App\Traits\CommandAccRegister;
use App\Traits\CommandInput;
use DB;

class CreateHrManAcc extends Command
{
    /**
     * trait for input generation.
     */
    use CommandInput;

    /**
     * trait for validation of Inputs.
     */
    use CommandValidation;

    use CommandAccRegister;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:hr-manager-acc';

    protected $user;
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
    public function __construct(UserEloquent $user)
    {
        parent::__construct();
        $this->user = $user;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {        
        if(!$this->user->isRoleExisting(4)) {
            $this->setRegisterValues();
            try {
                DB::beginTransaction();
                
                $this->setModel($this->user);
                $this->createSuperAdmin([1,2,4], $this->firstname, $this->lastname, $this->email, $this->pwd);

                DB::commit();
                $this->info('HR Account created for '.$this->firstname . ' ' . $this->lastname);

            }catch(\Exception $e) {
                
                $this->info('failed creation of HR account' . $e);
                DB::rollback();
            } 
        }else {

            $this->info('An HR Manager account was already created!');

        }   
    }

}
