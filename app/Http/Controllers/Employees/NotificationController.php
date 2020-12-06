<?php

namespace App\Http\Controllers\Employees;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Eloquent\Implementations\NotificationEloquent;

class NotificationController extends Controller
{
    protected $notification;

    public function __construct(NotificationEloquent $notification) {
        $this->notification = $notification;
    }
    public function getByUser($user_id) {
        $res = $this->notification->where('user_id', $user_id)->orderBy('created_at', 'DESC')->limit(5)->get();
        return $res;
    }
    public function countUnSeenByUser($user_id) {
        $res = $this->notification->where('user_id', $user_id)->where('is_seen', 0)->count();
        return $res;
    }
    public function readNotification($id) {
        $res = $this->notification->findOrFail($id)->update(['is_seen'=> 1]);
        return response()->json( ['data' => ['message' => $res]], 200);
    }
    public function moredNotification($user_id, Request $request) {
        $res = $this->notification->where('user_id', $user_id)->orderBy('created_at', 'DESC')->limit(5 + $request->limit)->get();
        return $res;
    }
    public function markAsReadNotification($user_id) {
        $res = $this->notification->where('user_id', $user_id)->where('is_seen', 0)->update(['is_seen'=> 1]);
        return response()->json( ['data' => ['message' => $res]], 200);
    }
}
