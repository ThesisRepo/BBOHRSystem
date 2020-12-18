<?php

namespace App\Http\Controllers\Admin\Requests;

use Illuminate\Http\Request;
use App\Eloquent\Implementations\Requests\LeaveRequestEloquent;
use App\Services\UserRequestService;
use App\Services\UserService;
use App\Services\ApproverRequestService;

class LeaveRequestController  extends RequestBaseController
{
    protected $leave_request;

    public function __construct(
        LeaveRequestEloquent $leave_request,
        ApproverRequestService $request_service,
        UserRequestService $user_request_service,
        UserService $user_service
    ) {

        $this->middleware(['auth', 'verify.admin']);  
        $this->leave_request = $leave_request;
        parent::__construct($request_service,  $leave_request, $user_request_service, 'leave_request', $user_service);
    }

    public function requestFeedback(Request $request, $id) {
        $res = $this->requestBaseFeedback($id, $request);     
        return $res;
    }

    public function getAllNonPendingLeaveRequest() {
        $res = $this->getAllNonPendingRequestBase();     
        return $res;
    }
}
