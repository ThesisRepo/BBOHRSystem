<?php

namespace App\Http\Controllers\PRP\Requests;

use Illuminate\Http\Request;
use App\Eloquent\Implementations\Requests\TravelAuthRequestEloquent;
use App\Services\ApproverRequestService;
use App\Services\UserRequestService;
use App\Services\UserService;

class TravelAuthRequestsController extends RequestBaseController
{
    protected $travel_auth_request;

    public function __construct(
        TravelAuthRequestEloquent $travel_auth_request,
        ApproverRequestService $request_service,
        UserRequestService $user_request_service,
        UserService $user_service
    ) {

        $this->middleware(['auth', 'verify.prp']);  
        $this->travel_auth_request = $travel_auth_request;
        parent::__construct($request_service,  $travel_auth_request, $user_request_service, 'travel_auth_request', $user_service);
    }
    
    public function getPendingRequest($id){
        $res = $this->getBasePendingRequest($id, ['status','approver_role', 'user', 'employee_to_cover']);
        return $res;
    }

    public function getAllFeedbackedRequest($user_id){
        $res = $this->getBaseAllFeedbackedRequest($user_id, 'feedbacked_travel_auth_requests', ['status','approver_role', 'user', 'employee_to_cover']);
        return $res;
    }

    public function getAllApprovedRequest($user_id){
        $res = $this->getBaseAllApprovedRequest($user_id, 'feedbacked_travel_auth_requests');   
        return $res; 
    }

    public function getAllDisapprovedRequest($user_id){
        $res = $this->getBaseAllDisapprovedRequest($user_id, 'feedbacked_travel_auth_requests');      
        return $res;
    }

    public function requestFeedback($id, Request $request){
        $res = $this->requestBaseFeedback($id, $request);     
        return $res;      
    }
}
