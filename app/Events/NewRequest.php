<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\Notification;
use DB;

class NewRequest implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

      
    public $username;

    public $message;

    public $request_type;

    public $id;

    public $data;
    /**
     * Create a new event instance.
     *
     * @return void
     */

    public function __construct($action, $username, $id, $request_type, $data)
    {
        $this->username = $username;
        // $this->data = $data;
        $this->id = $id;
        switch($request_type){
            case 'leave_request':
                    $this->request_type = 'Leave Request';
                break;  
            case 'shift_change_request':
                    $this->request_type = 'Shift Change Request';
                break; 
            case 'overtime_request':
                    $this->request_type = 'Overtime Request';
                break;   
            case 'petty_cash_request':
                    $this->request_type = 'Petty Cash Request';
                break;    
            case 'budget_request':
                    $this->request_type = 'Budget Request';
                break;    
            case 'travel_auth_request':
                    $this->request_type = 'Travel Authorization Request';
                break; 
        }
        // $this->message  = "{$username} {$action}" "a\an {$this->request_type}";
        $this->message  = "{$username} {$action}" . (in_array($this->request_type[0], ['A', 'E', 'I', 'O', 'U'] ) ?   " an " :  " a ") . $this->request_type;
        $data = [
            'user_id' => $this->id,
            'request_type' => $this->request_type,
            'message' => $this->message
        ];
        $this->data = Notification::create($data);
    }
    public function broadcastOn() {
        return new PrivateChannel('newrequest.' . $this->id);
        
    }
}
