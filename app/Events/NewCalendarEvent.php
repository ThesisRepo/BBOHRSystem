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
use App\Models\User;

class NewCalendarEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $username;

    public $message;

    public $data;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($action, $username, $id, $data)
    {
        $this->username = $username;
        $this->data = $data;
        $this->message  = "{$username} {$action}" . " a calendar event" . "{$id} dfd" ;
        $datum = [
            'message' => $this->message
        ];    
        $users = User::where('id', '!=', $id)->get()->toArray();
        foreach($users as $user) {
            User::find($user['id'])->notifications()->create($datum )->save();
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('newcalendarevent');
    }
}
