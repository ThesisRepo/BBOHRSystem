<?php

namespace App\Http\Controllers\PRP\Requests;

use Illuminate\Http\Request;
use App\Eloquent\Implementations\Requests\PettyCashRequestEloquent;
use App\Services\ApproverRequestService;
use App\Services\UserRequestService;
use App\Services\UserService;

class PettyCashRequestsController extends RequestBaseController
{
    protected $petty_cash_request;

    public function __construct(
        PettyCashRequestEloquent $petty_cash_request,
        ApproverRequestService $request_service,
        UserRequestService $user_request_service,
        UserService $user_service

    ) {

        $this->middleware(['auth','verify.prp']);  
        $this->petty_cash_request = $petty_cash_request;
        parent::__construct($request_service,  $petty_cash_request, $user_request_service, 'petty_cash_request', $user_service);
    }
    
    public function getPendingRequest($id){
        $res = $this->getBasePendingRequest($id, ['department', 'status','approver_role', 'user']);
        return $res;
    }

    public function getPendingRequestHR(){
        $res = $this->petty_cash_request->whereWith('status_id', 1, ['department', 'status','approver_role', 'user'])->get();
        return $res;
    }

    public function getAllFeedbackedRequest($user_id){
        $res = $this->getBaseAllFeedbackedRequest($user_id, 'feedbacked_petty_cash_requests', ['department', 'status','approver_role', 'user']);
        return $res;
    }

    public function getAllApprovedRequest($user_id){
        $res = $this->getBaseAllApprovedRequest($user_id, 'feedbacked_petty_cash_requests');   
        return $res; 
    }

    public function getAllDisapprovedRequest($user_id){
        $res = $this->getBaseAllDisapprovedRequest($user_id, 'feedbacked_petty_cash_requests');      
        return $res;
    }

    public function requestFeedback($id, Request $request){
        $res = $this->requestBaseFeedback($id, $request);     
        return $res;      
    }
}
