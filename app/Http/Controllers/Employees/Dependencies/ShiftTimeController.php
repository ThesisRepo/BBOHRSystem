<?php

namespace App\Http\Controllers\Employees\Dependencies;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Eloquent\Implementations\RequestDependencies\ShiftTimeEloquent;
use Auth;
use DB;

class ShiftTimeController extends Controller
{
    protected $shift_time;

    public function __construct(
        ShiftTimeEloquent $shift_time
    ) {

        $this->middleware(['auth', 'verify.employee']);  
        $this->shift_time = $shift_time;
    }
    
    public function index() {
        return $this->shift_time->all();
    }

    public function getUserShiftTime() {
        $shift_time_id = Auth::user()->load('userInformation')->userInformation->shift_time_id;
        return $this->shift_time->where('id','!=', $shift_time_id)->get();
    }
}
