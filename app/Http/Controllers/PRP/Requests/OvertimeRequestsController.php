<?php

namespace App\Http\Controllers\PRP\Requests;

use Illuminate\Http\Request;
use App\Eloquent\Implementations\Requests\OvertimeRequestEloquent;
use App\Services\ApproverRequestService;
use App\Services\UserRequestService;
use App\Services\UserService;

class OvertimeRequestsController extends RequestBaseController
{
    protected $overtime_request;

    public function __construct(
        OvertimeRequestEloquent $overtime_request,
        ApproverRequestService $request_service,
        UserRequestService $user_request_service,
        UserService $user_service

    ) {

        $this->middleware(['auth', 'verify.prp']);  
        $this->overtime_request = $overtime_request;
        parent::__construct($request_service,  $overtime_request, $user_request_service, 'overtime_request',  $user_service);
    }
    
    public function getPendingRequest($id){
        $res = $this->getBasePendingRequest($id, ['status','approver_role', 'user']);
        return $res;
    }

    public function getAllFeedbackedRequest($user_id){
        $res = $this->getBaseAllFeedbackedRequest($user_id, 'feedbacked_overtime_requests', ['status','approver_role', 'user']);
        return $res;
    }

    public function getAllApprovedRequest($user_id){
        $res = $this->getBaseAllApprovedRequest($user_id, 'feedbacked_overtime_requests');   
        return $res; 
    }

    public function getAllDisapprovedRequest($user_id){
        $res = $this->getBaseAllDisapprovedRequest($user_id, 'feedbacked_overtime_requests');      
        return $res;
    }

    public function requestFeedback($id, Request $request){
        $res = $this->requestBaseFeedback($id, $request);     
        return $res;      
    }
}
