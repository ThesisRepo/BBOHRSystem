<?php

namespace App\Http\Controllers\Employees;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Eloquent\Implementations\CalendarEventEloquent;
use App\Services\UserRequestService;
use App\Services\UserService;
use App\Models\CalendarEvent;

class CalendarEventController extends Controller
{
    protected $calendar_event;

    protected $user_service;

    protected $calendar_eves;

    public function __construct(
        CalendarEventEloquent $calendar_event,
        UserRequestService $user_request_service,
        UserService $user_service,
        CalendarEvent $calendar_eves
    ) {
        $this->middleware(['auth', 'verify.employee']);  
        $this->calendar_event = $calendar_event;
        $this->user_request_service = $user_request_service;
        $this->user_service = $user_service;
        $this->calendar_eves = $calendar_eves;
    }

    public function getByUser($user_id) {
        $relationship = 'event_type';
        $res = $this->calendar_event->whereWith('user_id', $user_id, $relationship)->orWhere('is_public', 1)->get();
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
        $employee_name = $this->getFullName();
        $this->notifyNewEventCalendar('added', $employee_name, $res);
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
        $employee_name = $this->getFullName();
        $this->notifyNewEventCalendar('updated', $employee_name, $res);        
        return response()->json($res, 200);
    }

    public function delete($id) {
        $res = $this->calendar_event->delete($id);
        $employee_name = $this->getFullName();
        $this->notifyNewEventCalendar('deleted', $employee_name, $res);
        return response()->json($res, 200);
    }

    public function notifyNewEventCalendar($action, $user, $data) {

        return $this->user_request_service->notifyNewEventCalendar($action, $user,$this->getUserId(), $data);  

    }

    public function getFullName(){

        return $this->user_service->getFullName();

    }
    public function getUserId(){

        return $this->user_service->getUserId();

    }

}
