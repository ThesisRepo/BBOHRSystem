<?php

namespace App\Http\Controllers\PRP\Requests;

use Illuminate\Http\Request;
use App\Eloquent\Implementations\Requests\BudgetRequestEloquent;
use App\Services\ApproverRequestService;

class BudgetRequestsController extends RequestBaseController
{
    protected $budget_request;

    public function __construct(
        LeaveRequestEloquent $budget_request,
        ApproverRequestService $request_service
    ) {

        $this->middleware(['auth', 'verify.prp', 'verify.manager.finance']);  
        $this->budget_request = $budget_request;
        parent::__construct($request_service,  $budget_request, 'budget_request');
    }
    
    public function getPendingRequest($id){
        $res = $this->getBasePendingRequest($id, ['department', 'status','approver_role', 'user']);
        return $res;
    }

    public function getAllFeedbackedRequest($user_id){
        $res = $this->getBaseAllFeedbackedRequest($user_id, 'feedbacked_budget_requests', ['department', 'status','approver_role', 'user']);
        return $res;
    }

    public function getAllApprovedRequest($user_id){
        $res = $this->getBaseAllApprovedRequest($user_id, 'feedbacked_budget_requests');   
        return $res; 
    }

    public function getAllDisapprovedRequest($user_id){
        $res = $this->getBaseAllDisapprovedRequest($user_id, 'feedbacked_budget_requests');      
        return $res;
    }

    public function requestFeedback($id, Request $request){
        $res = $this->requestBaseFeedback($id, $request);     
        return $res;      
    }
}