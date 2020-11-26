<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\IgnoredRequestsJob;
use DB;
use App\Models\User;
use App\Services\AllUserRequestsService;

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

    protected $request_service;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct( AllUserRequestsService $request_service, User $user)
    {
        $this->user = $user;
        $this->request_service = $request_service;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
        // dd($this->user->request_ignored());
        $users = $this->user->request_ignored();
        // foreach( $users as $user_indv) {
        //     $this->request_service->getAllPendingRequests($user_indv) {

        //     };
        // }
        dd($this->request_service->getAllPendingRequests($users[0]));

        $time_in_24_hour_format  = date("H:i", strtotime("1pm"));
        // dd($time_in_24_hour_format  );
    }
}
