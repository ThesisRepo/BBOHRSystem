<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Eloquent\Implementations\UserEloquent;
use App\Traits\CommandInput;
use App\Traits\CommandValidation;
use App\Traits\CommandAccRegister;
use DB;

class CreateFinanceManAcc extends Command
{
    /**
     * trait for input generation.
     */
    use CommandInput;

    /**
     * trait for input validations.
     */
    use CommandValidation;

    use CommandAccRegister;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:finance-manager-acc';

    protected $user;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command creates default finance manager account.If a finance manager account already existed then it won\'t generate a new account';

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
        if(!$this->user->isRoleExisting(3)) {
            $this->setRegisterValues();
            try {
                DB::beginTransaction();

                $this->setModel($this->user);
                $this->createSuperAdmin(3, $this->firstname, $this->lastname, $this->email, $this->pwd);

                DB::commit();
                $this->info('Finance Manager Account created for '.$this->firstname . ' ' . $this->lastname);

            }catch(\Exception $e) {

                DB::rollback();
                $this->info('failed creation of Finance Manager account' . $e);

            }   
        }else {

            $this->info('A Finance Manager account was already created!');

        }     
    }
}
