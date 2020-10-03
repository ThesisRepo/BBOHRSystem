<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateGenManAcc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:general-manager-acc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command creates default finance manager account.If a gm account already existed then it won\'t generate a new account';

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
        //
    }
}
