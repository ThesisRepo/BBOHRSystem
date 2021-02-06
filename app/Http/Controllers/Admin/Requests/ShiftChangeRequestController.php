<?php

namespace App\Http\Controllers\Admin\Requests;

use Illuminate\Http\Request;
use App\Eloquent\Implementations\Requests\ShiftChangeRequestEloquent;
use App\Services\UserRequestService;
use App\Services\UserService;
use App\Services\ApproverRequestService;

class ShiftChangeRequestController extends RequestBaseController
{
    protected $shift_change_request;

    public function __construct(
        ShiftChangeRequestEloquent $shift_change_request,
        ApproverRequestService $request_service,
        UserRequestService $user_request_service,
        UserService $user_service
    ) {

        $this->middleware(['auth', 'verify.admin']);  
        $this->shift_change_request = $shift_change_request;
        parent::__construct($request_service,  $shift_change_request, $user_request_service, 'shift_change_request', $user_service);
    }

    public function pending() {
        $with =  ['department', 'shift_time', 'status','approver_role', 'user'];
        $res = $this->getBasePendingRequest($with);     
        return $res;
    }
    public function requestFeedback(Request $request, $id) {
        $res = $this->requestBaseFeedback($id, $request, true);     
        return $res;
    }

    public function getAllNonPendingLeaveRequest() {
        $with =  ['department', 'shift_time', 'status','approver_role', 'user'];
        $res = $this->getAllNonPendingRequestBase($with);     
        return $res;
    }
}
