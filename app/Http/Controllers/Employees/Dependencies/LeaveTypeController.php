<?php

namespace App\Http\Controllers\Employees\Dependencies;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Eloquent\Implementations\RequestDependencies\LeaveTypeEloquent;


class LeaveTypeController extends Controller
{
    protected $leave_type;

    public function __construct(
        LeaveTypeEloquent $leave_type
    ) {

        $this->middleware(['auth', 'verify.employee']);  
        $this->leave_type = $leave_type;
    }
    public function index() {
        return $this->leave_type->all();
    }
}
