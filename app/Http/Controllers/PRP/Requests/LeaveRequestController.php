<?php

namespace App\Http\Controllers\PRP\Requests;

use Illuminate\Http\Request;
use App\Eloquent\Implementations\Requests\LeaveRequestEloquent;
use App\Http\Controllers\Controller;
use App\Services\ApproverRequestService;
use App\Models\Requests\LeaveRequest;

class LeaveRequestController extends RequestBaseController
{
    protected $leave_request;
    protected $request_service;

    public function __construct(
        LeaveRequestEloquent $leave_request,
        ApproverRequestService $request_service
    ) {

        $this->middleware(['auth', 'verify.prp']);  
        $this->leave_request = $leave_request;
        $this->request_service = $request_service;
        $this->request_service->setRequestType('leave_request');
    }
    
    public function getPendingRequest($id){

        $user = $this->request_service->getUserRoles($id);
        $max_role = $this->request_service->getMaxRoles($user->roles);
        if($max_role == 2){
            $res = $this->leave_request->getPendingRequestForApprover($id, $max_role);
        }else {
            $res = $this->leave_request->getPendingRequestForApproverAdmin($id, $max_role);            
        }

        return $res;

    }

    public function getAllFeedbackedRequest($user_id){

        return $this->request_service->getAllFeedbackedRequest($user_id, 'feedbacked_leave_requests');
    
    }

    public function getAllApprovedRequest($user_id){

        $user = $this->request_service->getUserRoles($user_id);
        $max_role = $this->request_service->getMaxRoles($user->roles);
        if($max_role == 5 ) {

            return $this->request_service->getAllApprovedRequest($user_id, 'feedbacked_leave_requests', true);

        }
        return $this->request_service->getAllApprovedRequest($user_id, 'feedbacked_leave_requests');
    
    }

    public function getAllDisapprovedRequest($user_id){

        return $this->request_service->getAllDisapprovedRequest($user_id, 'feedbacked_leave_requests');
    
    }

    public function requestFeedback($id, Request $request){

        $data = [];
        $user = $this->request_service->getUserRoles($request->user_id);
        $max_role = $this->request_service->getMaxRoles($user->roles);
        $current_request = $this->leave_request->find($id);   
        $next_approver = $this->request_service->getNextApprover($max_role);
        if($current_request->approver_role_id == $max_role || ($current_request->approver_role_id == $next_approver && $current_request->status_id == 1)) {
            if($request->status_id == 2) {
                if($max_role != 5) {
                    $data['approver_role_id'] = $next_approver;
                }else {
                    $data['status_id'] = $request->status_id;
                }
                $res = $this->leave_request->approveRequest($id, $data, $current_request, $user);
            }else if($request->status_id == 3){
                $data['status_id'] = $request->status_id;
                $data['approver_role_id'] = $max_role;
                $res = $this->leave_request->disapproveRequest($id, $data, $current_request, $user);
            }
            return $res;
        }else {
            return response()->json(['message'=> 'don\'t have permission to make feedback on this request'], 400);
        } 


    }
}
