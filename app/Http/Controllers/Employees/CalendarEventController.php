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

    public function show($user_id) {
        $res = $this->calendar_event->where('user_id', $user_id);
        return $res;
    }
}
