<?php

namespace App\Http\Controllers\Employees;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Eloquent\Implementations\CalendarEventEloquent;

class CalendarEventController extends Controller
{
    protected $calendar_event;

    public function __construct(
        CalendarEventEloquent $calendar_event
    ) {
        $this->middleware(['auth', 'verify.employee']);  
        $this->calendar_event = $calendar_event;
    }

    public function getByUser($user_id) {
        // $user_id = $request->user_id;
        $relationship = 'event_type';
        $res = $this->calendar_event->whereWith('user_id', $user_id, $relationship)->get();
        // dd($user_id);
        return $res;
    }

    public function store(Request $request) {
        $data = [
            'user_id' => $request->user_id,
            'title' => $request->title,
            'content' => $request->content,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_private' => $request->is_private,
            'event_type_id' => $request->event_type_id
        ];
        $res = $this->calendar_event->create($data);
        return $res;
    }

    public function update(Request $request, $id) {
        $data = [
            'user_id' => $request->user_id,
            'title' => $request->title,
            'content' => $request->content,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_private' => $request->is_private,
            'event_type_id' => $request->event_type_id
        ];
        $res = $this->calendar_event->find($id)->update($data);
        return response()->json($res, 200);
    }

    public function delete($id) {
        $res = $this->calendar_event->delete($id);
        return response()->json($res, 200);
    }

}
