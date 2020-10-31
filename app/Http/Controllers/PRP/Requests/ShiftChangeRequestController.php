<?php

namespace App\Http\Controllers\PRP\Requests;

use Illuminate\Http\Request;
use App\Eloquent\Implementations\Requests\ShiftChangeRequestEloquent;
use App\Services\ApproverRequestService;

class ShiftChangeRequestController extends RequestBaseController
{
    protected $shift_change_request;

    public function __construct(
        ShiftChangeRequestEloquent $shift_change_request,
        ApproverRequestService $request_service
    ) {

        $this->middleware(['auth', 'verify.prp']);  
        $this->shift_change_request = $shift_change_request;
        parent::__construct($request_service,  $shift_change_request, 'shift_change_request');
    }
    
    public function getPendingRequest($id){

        $res = $this->getBasePendingRequest($id,['user', 'status', 'approver_role', 'shift_time']);

        return $res;

    }

    public function getAllFeedbackedRequest($user_id){

        $res = $this->getBaseAllFeedbackedRequest($user_id, 'feedbacked_shift_change_requests');
        
        return $res;

    }

    public function getAllApprovedRequest($user_id){

        $res = $this->getBaseAllApprovedRequest($user_id, 'feedbacked_shift_change_requests');

        return $res;
    
    }

    public function getAllDisapprovedRequest($user_id){

        $res = $this->getBaseAllDisapprovedRequest($user_id, 'feedbacked_shift_change_requests');
        
        return $res;

    }

    public function requestFeedback($id, Request $request){

        $res = $this->requestBaseFeedback($id, $request);

        return $res;
        
    }
}
