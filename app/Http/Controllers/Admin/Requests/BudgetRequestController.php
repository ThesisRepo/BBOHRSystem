<?php

namespace App\Http\Controllers\Admin\Requests;

use Illuminate\Http\Request;
use App\Eloquent\Implementations\Requests\BudgetRequestEloquent;
use App\Services\UserRequestService;
use App\Services\UserService;
use App\Services\ApproverRequestService;

class BudgetRequestController extends RequestBaseController
{
    protected $budget_request;

    public function __construct(
        BudgetRequestEloquent $budget_request,
        ApproverRequestService $request_service,
        UserRequestService $user_request_service,
        UserService $user_service
    ) {

        $this->middleware(['auth', 'verify.admin']);  
        $this->budget_request = $budget_request;
        parent::__construct($request_service,  $budget_request, $user_request_service, 'budget_request', $user_service);
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
