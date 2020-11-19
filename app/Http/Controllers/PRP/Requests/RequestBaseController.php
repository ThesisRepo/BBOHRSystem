<?php

namespace App\Http\Controllers\PRP\Requests;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Eloquent\Implementations\Requests\EloquentRequestImplementation;
use App\Services\ApproverRequestService;

class RequestBaseController extends Controller
{
    protected $model;
    protected $request_service;

    public function __construct(
        ApproverRequestService $request_service,
        EloquentRequestImplementation $model,
        $request_type
    ) {

        $this->middleware(['auth', 'verify.prp']);  
        $this->model = $model;
        $this->request_service = $request_service;
        $this->request_service->setRequestType($request_type);
    }
    
    public function getBasePendingRequest($id, $relationship){
        
        $user = $this->request_service->getUserRoles($id);
        $max_role = $this->request_service->getMaxRoles($user->roles);
        if($max_role == 2){
            $res = $this->model->getPendingRequestForApprover($id, $max_role, $relationship);
        }else {
            $res = $this->model->getPendingRequestForApproverAdmin($id, $max_role, $relationship);            
        }
        // dd($res, $user->toArray());getPendingRequestForApproverAdmin
        return $res;

    }

    public function getBaseAllFeedbackedRequest($user_id, $relationship, $nested_relationship){
        $res = $this->request_service->getAllFeedbackedRequest($user_id, $relationship, $nested_relationship);
        return $res;
    }

    public function getBaseAllApprovedRequest($user_id, $relationship){

        $user = $this->request_service->getUserRoles($user_id);
        $max_role = $this->request_service->getMaxRoles($user->roles);
        if($max_role == 5 ) {

            $res = $this->request_service->getAllApprovedRequest($user_id, $relationship, true);

            return $res;

        }

        $res = $this->request_service->getAllApprovedRequest($user_id, $relationship);

        return $res;
    
    }

    public function getBaseAllDisapprovedRequest($user_id, $relationship){

       $res = $this->request_service->getAllDisapprovedRequest($user_id, $relationship);
        
       return $res;

    }

    public function requestBaseFeedback($id, Request $request){
        $data = [];
        $user = $this->request_service->getUserRoles($request->user_id);
        $max_role = $this->request_service->getMaxRoles($user->roles);
        $current_request = $this->model->find($id);   
        $next_approver = $this->request_service->getNextApprover($max_role);
        if($current_request->approver_role_id == $max_role || ($current_request->approver_role_id == $next_approver && $current_request->status_id == 1)) {
            // if($request->status_id == 2) {
                if($request->status_id == 3){
                    $data['status_id'] = $request->status_id;
                    $data['approver_role_id'] = $max_role;
                    return $this->model->disapproveRequest($id, $data, $current_request, $user);
                }
                if($max_role != 5) {
                    $data['approver_role_id'] = $next_approver;
                }else {
                    $data['status_id'] = $request->status_id;
                }
                $res = $this->model->approveRequest($id, $data, $current_request, $user);
            return $res;
        }else {
            return response()->json(['message'=> 'don\'t have permission to make feedback on this request'], 400);
        } 


    }
}
