<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewRequest implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

      
    public $username;

    public $message;

    public $request_type;
    /**
     * Create a new event instance.
     *
     * @return void
     */

    public function __construct($action, $username, $request_type)
    {
        $this->username = $username;
        switch($request_type){
            case 'leave_request':
                    $this->request_type = 'Leave Request';
                break;  
        }
        $this->message  = "{$username} {$action} a\an {$this->request_type}";
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    // public function broadcastOn()
    // {
    //     return ['new_request'];
    // }

    public function broadcastOn() {

        return new Channel('newrequest');
        
    }

    // public function broadcastWith() {

    //     return [
    //         'username' => $this->username,
    //         'message' => $this->message,
    //         'usertype' => $this->request_type,

    //     ];

    // }
}
