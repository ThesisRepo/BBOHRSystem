<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\IgnoredRequestsJob;
use DB;
use App\Models\User;
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
    protected $user;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct( User $user)
    {
        $this->user = $user;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
        dd($this->user->request_ignored());
        // $time_in_24_hour_format  = date("H:i", strtotime("1pm"));
        // dd($time_in_24_hour_format  );
    }
}
