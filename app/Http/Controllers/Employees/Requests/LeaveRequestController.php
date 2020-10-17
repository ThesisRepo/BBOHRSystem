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
        parent::setRequestName('leave_request');
    }
    
    // public function index($id) {
    //     return $this->leave_request->getWhere('user_id', $id);
    // }

    public function store(Request $request) {

        $prp_assigned_id = $request->prp_assigned_id;
        $requestData = [
            'user_id'=> $request->user_id,
            'leave_type_id'=> $request->leave_type_id,
            'start_date'=> $request->start_date,
            'end_date'=> $request->end_date,
            'number_of_days'=> $request->number_of_days,
            'approver_role_id'=> $this->nextApproverId($request->user_id),
            'status_id'=> 1
        ];
        return $this->leave_request->createRequest($requestData, $prp_assigned_id);
    }

    public function update(Request $request, $id) {

        $current_leave_request = $this->leave_request->find($id);
        
        if($this->isEditable($current_leave_request )){

            $prp_assigned_id = $request->prp_assigned_id;
            $requestData = [
                'leave_type_id'=> $request->leave_type_id,
                'start_date'=> $request->start_date,
                'end_date'=> $request->end_date,
                'reason'=> $request->reason,
                'number_of_days'=> $request->number_of_days
            ];
            
            return response()->json($this->leave_request->updateRequest($requestData, $id, $prp_assigned_id), 200);
        }else{
            return response()->json([], 400);
        }
        
    }

    public function show( $id) {
        return $this->leave_request->getWhereWith('user_id', $id, ['leave_type', 'status']);
    }

    // public function delete( $id) {
    //     return $this->leave_request->deleteWhere('user_id', $id);
    // }
}
