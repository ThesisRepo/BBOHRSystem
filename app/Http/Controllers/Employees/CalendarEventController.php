<?php

namespace App\Http\Controllers\Employees;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Eloquent\Implementations\CalendarEventEloquent;
use App\Services\UserRequestService;

class CalendarEventController extends Controller
{
    protected $calendar_event;

    public function __construct(
        CalendarEventEloquent $calendar_event,
        UserRequestService $user_request_service
    ) {
        $this->middleware(['auth', 'verify.employee']);  
        $this->calendar_event = $calendar_event;
        $this->user_request_service = $user_request_service;
    }

    public function getByUser($user_id) {
        $relationship = 'event_type';
        $res = $this->calendar_event->whereWith('user_id', $user_id, $relationship)->orWhere('is_public', 1)->get();
        // dd($user_id, $res->toArray());
        return $res;
    }

    public function store(Request $request) {
        $data = [
            'user_id' => $request->user_id,
            'title' => $request->title,
            'content' => $request->content,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_public' => $request->is_public,
            'event_type_id' => $request->event_type_id
        ];
        $res = $this->calendar_event->create($data);
        // $this->notifyNewEventCalendar ('added', $employee_name, $prp_assigned_id, $this->request_name, $data);
        return $res;
    }

    public function update(Request $request, $id) {
        $data = [
            'user_id' => $request->user_id,
            'title' => $request->title,
            'content' => $request->content,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_public' => $request->is_public,
            'event_type_id' => $request->event_type_id
        ];
        $res = $this->calendar_event->find($id)->update($data);
        return response()->json($res, 200);
    }

    public function delete($id) {
        $res = $this->calendar_event->delete($id);
        return response()->json($res, 200);
    }

    public function notifyNewRequest($action, $user, $id, $type, $data) {

        return $this->user_request_service->notifyNewRequest($action, $user, $id, $type, $data);  

    }

}
