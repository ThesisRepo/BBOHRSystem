<?php

namespace App\Http\Controllers\PRP\Requests;

use Illuminate\Http\Request;
use App\Eloquent\Implementations\Requests\LeaveRequestEloquent;
use App\Services\ApproverRequestService;

class LeaveRequestController extends RequestBaseController
{
    protected $leave_request;

    public function __construct(
        LeaveRequestEloquent $leave_request,
        ApproverRequestService $request_service
    ) {

        $this->middleware(['auth', 'verify.prp']);  
        $this->leave_request = $leave_request;
        parent::__construct($request_service,  $leave_request, 'leave_request');
    }
    
    public function getPendingRequest($id){

        $res = $this->getBasePendingRequest($id);

        return $res;

    }

    public function getAllFeedbackedRequest($user_id){

        $res = $this->getBaseAllFeedbackedRequest($user_id, 'feedbacked_leave_requests');
        
        return $res;

    }

    public function getAllApprovedRequest($user_id){

        $res = $this->getBaseAllApprovedRequest($user_id, 'feedbacked_leave_requests');
        
        return $res;
    
    }

    public function getAllDisapprovedRequest($user_id){

        $res = $this->getBaseAllDisapprovedRequest($user_id, 'feedbacked_leave_requests');
        
        return $res;

    }

    public function requestFeedback($id, Request $request){

        $res = $this->requestBaseFeedback($id, $request);
        
        return $res;
        
    }
}
