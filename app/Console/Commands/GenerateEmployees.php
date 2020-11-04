<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\EmployeeInfoList;
use App\Models\User;

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
        foreach($this->employee_info_list as $employee_info) {
            User::create($employee_info);
        }
    }
}
