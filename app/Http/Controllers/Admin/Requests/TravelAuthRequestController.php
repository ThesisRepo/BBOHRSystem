<?php

namespace App\Http\Controllers\Admin\Requests;

use Illuminate\Http\Request;
use App\Eloquent\Implementations\Requests\TravelAuthRequestEloquent;
use App\Services\UserRequestService;
use App\Services\UserService;
use App\Services\ApproverRequestService;

class TravelAuthRequestController extends RequestBaseController
{
    protected $travel_auth_request;

    public function __construct(
        TravelAuthRequestEloquent $travel_auth_request,
        ApproverRequestService $request_service,
        UserRequestService $user_request_service,
        UserService $user_service
    ) {

        $this->middleware(['auth', 'verify.admin']);  
        $this->travel_auth_request = $travel_auth_request;
        parent::__construct($request_service,  $travel_auth_request, $user_request_service, 'travel_auth_request', $user_service);
    }

    public function pending() {
        $with =  ['status','approver_role', 'user', 'employee_to_cover', 'user.userInformation'];
        $res = $this->getBasePendingRequest($with);     
        return $res;
    }
    public function requestFeedback(Request $request, $id) {
        $res = $this->requestBaseFeedback($id, $request, true);     
        return $res;
    }

    public function getAllNonPendingLeaveRequest() {
        $with =  ['status','approver_role', 'user', 'employee_to_cover', 'user.userInformation'];
        $res = $this->getAllNonPendingRequestBase($with);     
        return $res;
    }
}
