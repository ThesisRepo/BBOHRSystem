<?php

namespace App\Http\Controllers\Employees\Requests;

use Illuminate\Http\Request;
use App\Eloquent\Implementations\Requests\ShiftChangeRequestEloquent;
use App\Eloquent\Implementations\UserEloquent;
use App\Eloquent\Implementations\RoleEloquent;

class ShiftChangeRequestController extends RequestBaseController
{
    protected $shift_change_request;

    public function __construct(
        ShiftChangeRequestEloquent $shift_change_request,
        RoleEloquent $role,
        UserEloquent $user
    ) {

        $this->middleware(['auth', 'verify.employee']);  
        $this->shift_change_request = $shift_change_request;
        parent::__construct($role ,$user);
        parent::setRequestName('shift_change_request');
    }

    public function show( $id) {
        return $this->shift_change_request->getWhereWith('user_id', $id, ['approver_role', 'status']);
    }
    
    public function store(Request $request) {

        $prp_assigned_id = $request->prp_assigned_id;
        $requestData = [
            'user_id'=> $request->user_id,
            'reason'=> $request->reason,
            'shift_date'=> $request->shift_date,
            'shift_time'=> $request->shift_time,
            'approver_role_id'=> $this->nextApproverId($request->user_id),
            'status_id'=> 1
        ];
        return $this->shift_change_request->createRequest($requestData, $prp_assigned_id);
    }   
}
