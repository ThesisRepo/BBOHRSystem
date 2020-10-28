<?php

namespace App\Http\Controllers\Employees\Requests;

use Illuminate\Http\Request;
use App\Eloquent\Implementations\Requests\LeaveRequestEloquent;
use App\Eloquent\Implementations\UserEloquent;
use App\Eloquent\Implementations\RoleEloquent;
use App\Services\UserRequestService;
use App\Services\UserService;

class LeaveRequestController extends RequestBaseController
{

    protected $leave_request;

    protected $user_request_service;
    
    protected $user_service;

    public function __construct(
        LeaveRequestEloquent $leave_request,
        RoleEloquent $role, 
        UserEloquent $user,
        UserRequestService $user_request_service,
        UserService $user_service

    ) {

        $this->middleware(['auth', 'verify.employee']);  
        $this->leave_request = $leave_request;
        $this->user_request_service = $user_request_service;
        $this->user_service = $user_service;
        parent::__construct($role,$user, $leave_request);
        parent::setRequestName('leave_request');
    }
    
    // public function index($id) {
    //     return $this->leave_request->getWhere('user_id', $id);
    // }

    public function store(Request $request) {

        $prp_assigned_id =  $this->setPrpId($request->prp_assigned_id);

        $requestData = [
            'user_id'=> $request->user_id,
            'leave_type_id'=> $request->leave_type_id,
            'department_id'=> $this->getDepartmentId($request->user_id),
            'start_date'=> $request->start_date,
            'end_date'=> $request->end_date,
            'number_of_days'=> $request->number_of_days,
            'approver_role_id'=> $this->nextApproverId($request->user_id),
            'status_id'=> 1
        ];
        $employee_name = $this->user_service->getFullName($request->user_id);
        $res = $this->storeRequest($requestData, $prp_assigned_id);
        $this->user_request_service->notifyNewRequest('added', $employee_name, $this->request_name);
        return $res;

    }

    public function update(Request $request, $id) {

        $current_leave_request = $this->leave_request->findWith($id,'user');
        $user_id = $current_leave_request->user->id;
        $prp_assigned_id = $this->setPrpId($request->prp_assigned_id);
        
        $requestData = [
            'leave_type_id'=> $request->leave_type_id,
            'department_id'=> $this->getDepartmentId($user_id),
            'start_date'=> $request->start_date,
            'end_date'=> $request->end_date,
            'number_of_days'=> $request->number_of_days
        ];
        
        return $this->updateRequest($current_leave_request, $requestData, $id, $prp_assigned_id);        
    }

    public function show( $id) {
        return $this->showRequest('user_id', $id, ['leave_type', 'status', 'approver_role']);
    }

    public function delete( $id) {
        return $this->deleteRequest($id);
    }
}
