<?php

namespace App\Http\Controllers\Employees\Requests;

use Illuminate\Http\Request;
use App\Eloquent\Implementations\Requests\LeaveRequestEloquent;
use App\Eloquent\Implementations\RequestDependencies\LeaveTypeEloquent;
use App\Eloquent\Implementations\UserEloquent;

use App\Eloquent\Implementations\RoleEloquent;

class LeaveRequestController extends RequestBaseController
{

    protected $leave_request;

    public function __construct(
        LeaveRequestEloquent $leave_request,
        RoleEloquent $role, 
        LeaveTypeEloquent $leave_type,
        UserEloquent $user
    ) {

        $this->middleware(['auth', 'verify.employee']);  
        $this->leave_request = $leave_request;
        parent::__construct($role, $leave_type, $user);
    }
    
    // public function index($id) {
    //     return $this->leave_request->getWhere('user_id', $id);
    // }

    public function store(Request $request) {
        $data = [
            'user_id'=> $request->user_id,
            'leave_type_id'=> $request->leave_type_id,
            'start_date'=> $request->start_date,
            'end_date'=> $request->end_date,
            'reason'=> $request->reason,
            'number_of_days'=> $request->number_of_days,
            'approver_role_id'=> $this->nextApproverId($request->user_id, 'leave_request'),
            'status_id'=> 1
        ];
        return $this->leave_request->create($data);
    }

    public function update(Request $request, $id) {
        
        $data = [
            'leave_type_id'=> $request->leave_type_id,
            'start_date'=> $request->start_date,
            'end_date'=> $request->end_date,
            'reason'=> $request->reason,
            'number_of_days'=> $request->number_of_days
        ];
        
        return response()->json($this->leave_request->update($data, $id), 200);
    }

    public function show( $id) {
        return $this->leave_request->getWhere('user_id', $id);
    }

    // public function delete( $id) {
    //     return $this->leave_request->deleteWhere('user_id', $id);
    // }
}
