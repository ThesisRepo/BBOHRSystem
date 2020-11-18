<?php

namespace App\Http\Controllers\Employees;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Eloquent\Implementations\EventTypeEloquent;

class EventTypeController extends Controller
{
    protected $event_type;

    public function __construct(
        EventTypeEloquent $event_type
    ) {

        $this->middleware(['auth', 'verify.employee']);  
        $this->event_type = $event_type;
    }
    public function index() {
        return $this->event_type->all();
    }

    public function show($id) {
        return $this->event_type->where('user_id', $id)->get();
    }

    public function delete($id) {
        $res = $this->event_type->delete($id);
        return response()->json($res);
    }
    public function update($id, Request $request) {
        $data = [
            'event_name' => $request->event_name,
            'color' => $request->color
        ];
        $res = $this->event_type->find($id)->update($data);
        return response()->json($res);
    }
}
