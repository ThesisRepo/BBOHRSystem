<?php

namespace App\Console\Commands\Schedulers;

use Illuminate\Console\Command;

class SendEmailForRequests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:ignoredRequests';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send the user an email of their ignoredRequests messages';

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