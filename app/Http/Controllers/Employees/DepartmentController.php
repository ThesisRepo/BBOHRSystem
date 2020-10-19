<?php

namespace App\Http\Controllers\Employees;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Eloquent\Implementations\DepartmentEloquent;


class DepartmentController extends Controller
{
    protected $department;

    public function __construct(
        LeaveTypeEloquent $department
    ) {

        $this->middleware(['auth', 'verify.employee']);  
        $this->department = $department;
    }
    public function index() {
        return $this->department->all();
    }
}
