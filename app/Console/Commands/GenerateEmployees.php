<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\EmployeeInfoList;
use App\Models\User;
// use App\Eloquent\Implementations\UserEloquent;

class GenerateEmployees extends Command
{

    use EmployeeInfoList;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:employees';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seeds Employees to DB';

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
        foreach($this->employee_info_list() as $employee_info) {
            $user = User::create($employee_info['user']);
            $user->roles()->attach($employee_info['user_roles']);
            if( $employee_info['user_info']) {
                $user->userInformation()->create($employee_info['user_info']);
            }
            if( $employee_info['user_company_positions']) {
                $user->userInformation->company_positions()->attach($employee_info['user_company_positions']);
            }
        }
        $this->info('initial employees were added to application');
    }
}
