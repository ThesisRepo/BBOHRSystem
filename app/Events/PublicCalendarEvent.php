<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\User;

class PublicCalendarEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $message;

    protected $data;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->message  = "{$data->event_type->event_name} : {$data->title} " . " is due within this hour";
        $datum = [
            'message' => $this->message
        ]; 
        $users = User::all()->toArray();
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
        return new Channel('public-calendar');
    }
}
