<?php

namespace App\Http\Controllers\Admin\Requests;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Eloquent\Implementations\Requests\OvertimeRequestEloquent;
use App\Services\UserRequestService;
use App\Services\UserService;
use App\Services\ApproverRequestService;

class OvertimeRequestController extends RequestBaseController
{
    //ApproverRequestService $request_service,
    // EloquentRequestImplementation $model,
    // UserRequestService $user_request_service,
    // $request_type,
    // UserService $user_service


    // public function __construct() {
    //     parent::__construct();
    // }

    protected $overtime_request;

    public function __construct(
        OvertimeRequestEloquent $overtime_request,
        ApproverRequestService $request_service,
        UserRequestService $user_request_service,
        UserService $user_service
    ) {

        $this->middleware(['auth', 'verify.admin']);  
        $this->overtime_request = $overtime_request;
        parent::__construct($request_service,  $overtime_request, $user_request_service, 'overtime_request', $user_service);
    }

    public function pending() {
        $with =  ['status','approver_role', 'user'];
        $res = $this->getBasePendingRequest($with);     
        return $res;
    }
    public function requestFeedback(Request $request, $id) {
        $res = $this->requestBaseFeedback($id, $request, true);     
        return $res;
    }

    public function getAllNonPendingLeaveRequest() {
        $with =  ['status','approver_role', 'user'];
        $res = $this->getAllNonPendingRequestBase($with);     
        return $res;
    }

}
