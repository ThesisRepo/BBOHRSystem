<?php

namespace App\Http\Controllers\Admin\Requests;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Eloquent\Implementations\Requests\EloquentRequestImplementation;
use App\Services\ApproverRequestService;
use App\Services\UserRequestService;
use App\Services\UserService;
use App\Models\Requests\LeaveRequest;

class RequestBaseController extends Controller
{
    protected $model;
    protected $request_service;
    protected $user_request_service;
    public $request_name;
    protected $request_type;
    protected $user_service;

    public function __construct(
        ApproverRequestService $request_service,
        EloquentRequestImplementation $model,
        UserRequestService $user_request_service,
        $request_type,
        UserService $user_service
    ) {

        $this->middleware(['auth', 'verify.admin']);  
        $this->model = $model;
        $this->request_service = $request_service;
        $this->request_type = $request_type;
        $this->user_request_service = $user_request_service;
        $this->user_service = $user_service;
    }

    public function getBasePendingRequest($relationship){
        $res = $this->model->whereWith('status_id', 1, $relationship)->get(); 
        return $res;
    }

    public function requestBaseFeedback($id, Request $request, $isAdmin = false){
        $data = [];
        $current_request = $this->model->with('user')->find($id);
        $with = ['roles'];
        if($this->request_type != 'budget_request' && $this->request_type != 'petty_cash_request') {
            $user = $this->user_service->findUserWith($current_request->user->prp_assigned, $with);
        }else {
            $user = $this->user_service->findUserWith($current_request->user->finance_mngr_assigned, $with);
        }
        $max_role = $this->request_service->getMaxRoles($user->roles);
        if($max_role != $current_request->approver_role_id) {
            $user = $this->user_service->whereNotAdminUserWith($current_request->approver_role_id, $with);
            $max_role = $this->request_service->getMaxRoles($user->roles);
        }
        $next_approver = $this->request_service->getNextApprover($max_role);
        $employee_name = $this->user_service->getFullNameWithParams($user->first_name, $user->last_name);
        $requester = $this->user_service->getFullNameWithParams($current_request->user->first_name, $current_request->user->last_name);
        $action = "";
        if($request->status_id == 3){
            $data['status_id'] = $request->status_id;
            $data['approver_role_id'] = $max_role;
            $action = "Disapproved (ADMIN)";
            $res = $this->model->disapproveRequest($id, $data, $current_request, $user);
            $this->notifyApprovedRequest($action, $employee_name,  $current_request->user->id, $this->request_type, $res);
            $this->notifyNewAdminRequest('Disapproved', 'Admin', $user->id, $this->request_type, $requester, $res, $user);
            $current_request->overriden_requests()->create(['roles_id' => $current_request->approver_role_id]);
            return $res;
        }
        if($max_role != 5) {
            $data['approver_role_id'] = $next_approver;
            $data['status_id'] = $request->status_id;
        }else {
            if($isAdmin) {
                $data['approver_role_id'] = 5;
            }
            $data['status_id'] = $request->status_id;
        }
        $action = "Approved (ADMIN)";
        $res = $this->model->approveRequest($id, $data, $current_request, $user);
        $this->notifyApprovedRequest($action, $employee_name, $current_request->user->id, $this->request_type, $res);
        $this->notifyNewAdminRequest('Approved', 'Admin', $user->id, $this->request_type, $requester, $res, $user);
        $current_request->overriden_requests()->create(['roles_id' => $current_request->approver_role_id]);
        return $res;
    }

    public function getAllNonPendingRequestBase($with = []) {
        $res = $this->model->with($with)->where('status_id', '!=', 1)->get();   
        return $res;
    }

    public function notifyApprovedRequest($action, $user, $id, $type, $data) {
        return $this->user_request_service->notifyNewRequest($action, $user, $id, $type, $data);  
    }

    public function notifyNewAdminRequest($action, $user, $id, $type, $requester, $data, $approver) {
        return $this->user_request_service->notifyNewAdminRequest($action, $user, $id, $type, $requester, $data, $approver);  
    }
}
