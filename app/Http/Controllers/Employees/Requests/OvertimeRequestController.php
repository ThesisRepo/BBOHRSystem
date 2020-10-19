<?php

namespace App\Http\Controllers\Employees\Requests;

use Illuminate\Http\Request;
use App\Eloquent\Implementations\Requests\OvertimeRequestEloquent;
use App\Eloquent\Implementations\UserEloquent;
use App\Eloquent\Implementations\RoleEloquent;

class OvertimeRequestController extends RequestBaseController
{
    protected $overtime_request;

    public function __construct(
        ShiftChangeRequestEloquent $overtime_request,
        RoleEloquent $role,
        UserEloquent $user
    ) {

        $this->middleware(['auth', 'verify.employee']);  
        $this->overtime_request = $overtime_request;
        parent::__construct($role ,$user, $overtime_request);
        parent::setRequestName('overtime_request');
    }

    public function show( $id) {
        return $this->showRequest('user_id', $id, ['approver_role', 'status']);
    }
    
    public function store(Request $request) {

        $prp_assigned_id = $request->prp_assigned_id;
        $requestData = [
            'user_id'=> $request->user_id,
            'reason'=> $request->reason,
            'date'=> $request->date,
            'start_time'=> $request->start_time,
            'end_time'=> $request->end_time,
            'approver_role_id'=> $this->nextApproverId($request->user_id ),
            'status_id'=> 1
        ];
        return $this->storeRequest($requestData, $prp_assigned_id);
    }
    
    public function update(Request $request, $id) {

        $current_overtime_request = $this->overtime_request->find($id);
        $prp_assigned_id = $request->prp_assigned_id;
        $requestData = [
            'reason'=> $request->reason,
            'date'=> $request->date,
            'start_time'=> $request->start_time,
            'end_time'=> $request->end_time,
        ];
        return $this->updateRequest($current_overtime_request , $requestData, $id, $prp_assigned_id);
    }

    public function delete( $id) {
        return $this->deleteRequest($id);
    }
}
