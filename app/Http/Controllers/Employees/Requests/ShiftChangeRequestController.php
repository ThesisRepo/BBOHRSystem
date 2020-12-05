<?php

namespace App\Http\Controllers\Employees\Requests;

use Illuminate\Http\Request;
use App\Eloquent\Implementations\Requests\ShiftChangeRequestEloquent;
use App\Eloquent\Implementations\UserEloquent;
use App\Eloquent\Implementations\RoleEloquent;
use App\Services\UserRequestService;
use App\Services\UserService;

class ShiftChangeRequestController extends RequestBaseController
{
    protected $shift_change_request;

    public function __construct(
        ShiftChangeRequestEloquent $shift_change_request,
        RoleEloquent $role,
        UserEloquent $user,
        UserRequestService $user_request_service,
        UserService $user_service
    ) {

        $this->middleware(['auth', 'verify.employee']);  
        $this->shift_change_request = $shift_change_request;
        parent::__construct($role ,$user, $shift_change_request, $user_request_service, $user_service);
        parent::setRequestName('shift_change_request');
    }

    public function show( $id) {
        $res = $this->showRequest('user_id', $id, ['approver_role', 'status', 'shift_time']);
        return $res;
    }
    
    public function store(Request $request) {

        if($this->isEqualShiftTime($request)) {
            return response()->json([],404);            
        }

        // $prp_assigned_id =  $this->setPrpId($request->prp_assigned_id);

        $requestData = [
            'user_id'=> $request->user_id,
            'department_id'=> $this->getDepartmentId($request->user_id),
            'reason'=> $request->reason,
            'shift_date'=> $request->shift_date,
            'shift_time_id'=> $request->shift_time_id,
            'approver_role_id'=> $this->nextApproverId($request->user_id ),
            'status_id'=> 1
        ];

        // return $this->storeRequest($requestData, $prp_assigned_id);

        $res = $this->storeRequest($requestData);

        return $res;
    }
    
    public function update(Request $request, $id) {

        if($this->isEqualShiftTime($request)) {
            return response()->json(['data'=>['message'=>'you can\'t change shift on current shift']], 400);            
        }

        $current_shift_change_request = $this->shift_change_request->findWith($id, 'user');
        $user_id = $current_shift_change_request->user->id;
        // $prp_assigned_id =  $this->setPrpId($request->prp_assigned_id);

        $requestData = [
            'department_id'=> $this->getDepartmentId($user_id),
            'reason'=> $request->reason,
            'shift_date'=> $request->shift_date,
            'shift_time_id'=> $request->shift_time_id,
        ];

        // return $this->updateRequest($current_shift_change_request, $requestData, $id, $prp_assigned_id);

        $res = $this->updateRequest($current_shift_change_request, $requestData, $id);

        return $res;  

    }

    public function delete( $id) {
        $res =  $this->deleteRequest($id);
        return $res;
    }

    public function isEqualShiftTime($data) {
        $for_update_shift_time = $data->shift_time_id;
        $current_shift_time = $this->user_service->getShiftTime()->load('userInformation.shift_time')->userInformation->shift_time->id;

        return $for_update_shift_time == $current_shift_time;
    }
}
