<?php

namespace App\Http\Controllers\Admin\Requests;

use Illuminate\Http\Request;
use App\Eloquent\Implementations\Requests\PettyCashRequestEloquent;
use App\Services\UserRequestService;
use App\Services\UserService;
use App\Services\ApproverRequestService;

class PettyCashRequestController extends RequestBaseController
{
    protected $petty_cash_request;

    public function __construct(
        PettyCashRequestEloquent $petty_cash_request,
        ApproverRequestService $request_service,
        UserRequestService $user_request_service,
        UserService $user_service
    ) {

        $this->middleware(['auth', 'verify.admin']);  
        $this->petty_cash_request = $petty_cash_request;
        parent::__construct($request_service,  $petty_cash_request, $user_request_service, 'petty_cash_request', $user_service);
    }

    public function pending() {
        $with =  ['department', 'status','approver_role', 'user'];
        $res = $this->getBasePendingRequest($with);     
        return $res;
    }
    public function requestFeedback(Request $request, $id) {
        $res = $this->requestBaseFeedback($id, $request, true);     
        return $res;
    }

    public function getAllNonPendingLeaveRequest() {
        $with =  ['department', 'status','approver_role', 'user'];
        $res = $this->getAllNonPendingRequestBase($with);     
        return $res;
    }
}
