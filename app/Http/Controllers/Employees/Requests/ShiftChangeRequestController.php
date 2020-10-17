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
        parent::__construct($role ,$user, $shift_change_request);
        parent::setRequestName('shift_change_request');
    }

    public function show( $id) {
        return $this->showRequest('user_id', $id, ['approver_role', 'status']);
    }
    
    public function store(Request $request) {

        $prp_assigned_id = $request->prp_assigned_id;
        $requestData = [
            'user_id'=> $request->user_id,
            'reason'=> $request->reason,
            'shift_date'=> $request->shift_date,
            'shift_time'=> $request->shift_time,
            'approver_role_id'=> $this->nextApproverId($request->user_id ),
            'status_id'=> 1
        ];
        return $this->storeRequest($requestData, $prp_assigned_id);
    }
    
    public function update(Request $request, $id) {

        $current_shift_change_request = $this->shift_change_request->find($id);
        $prp_assigned_id = $request->prp_assigned_id;
        $requestData = [
            'reason'=> $request->reason,
            'shift_date'=> $request->shift_date,
            'shift_time'=> $request->shift_time,
        ];
        return $this->updateRequest($current_shift_change_request, $requestData, $id, $prp_assigned_id);
    }

    public function delete( $id) {
        return $this->deleteRequest($id);
    }
}
