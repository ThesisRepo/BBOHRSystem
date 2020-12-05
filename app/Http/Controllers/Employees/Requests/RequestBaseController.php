<?php

namespace App\Http\Controllers\Employees\Requests;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Eloquent\Implementations\RoleEloquent;
use App\Eloquent\Implementations\RequestDependencies\LeaveTypeEloquent;
use App\Eloquent\Implementations\UserEloquent;
use App\Eloquent\Implementations\Requests\EloquentRequestImplementation;
use App\Services\UserRequestService;
use App\Services\UserService;

class RequestBaseController extends Controller
{

    protected $role;

    protected $user;

    protected $status;

    private $max_role;

    public $request_name;

    private $model;

    protected $user_request_service;
    
    protected $user_service;

    public function __construct(
        RoleEloquent $role,
        UserEloquent $user,
        EloquentRequestImplementation $model,
        UserRequestService $user_request_service,
        UserService $user_service
    ) {

        $this->middleware(['auth']);  
        $this->role = $role;
        $this->user = $user;
        $this->model = $model;
        $this->user_request_service = $user_request_service;
        $this->user_service = $user_service;

    }

    public function getRoles($id) {

        return $this->user->findWith($id, 'roles')->roles;

    }

    //can also be found in RequestsService
    public function setMaxRoles($roleArr) {

        foreach( $roleArr as  $datum) {
            $this->max_role = $datum->id > $this->max_role ? $datum->id : $this->max_role;
        }

    }

    public function setRequestName($request_name) {

        $this->request_name = $request_name;

    }

    public function getMaxRoles(){

        return $this->max_role;

    }

    public function findDepartment($id) {

        return $this->user->findWith($id, 'userInformation')->userInformation->department_id;

    }

    public function nextApproverId($id) {

        $this->setMaxRoles($this->getRoles($id));
        if($this->request_name == 'petty_cash_request' || $this->request_name == 'budget_request' && $this->max_role != 2) {
            if($this->max_role == 4) {
                $this->max_role --;
            }else {
                $this->max_role += 2;
            }
        }else {
            $this->max_role ++;
            if($this->max_role == 3){
                $this->max_role ++;
            }
        }

        return $this->max_role; 

    }


    public function isEditable($data) {
        $approver_role_id = $data->approver_role_id;
        if($data->status_id == 1) {
            $this->setMaxRoles($this->getRoles($data->user_id));
            // dd($this->max_role);
            $status_id = $data->status_id;
            switch($this->max_role) {
                case 1:
                    if($this->request_name == 'petty_cash_request' || $this->request_name == 'budget_request') {
                        return $approver_role_id == $this->max_role + 2;
                    }else {
                        return $approver_role_id == $this->max_role + 1;
                    }
                    break;
                case 2:
                    if($this->request_name == 'petty_cash_request' || $this->request_name == 'budget_request') {
                        return $approver_role_id == $this->max_role + 1;
                    }else {
                        return $approver_role_id == $this->max_role + 2;
                    }
                    break;
                case 3:
                    if($this->request_name == 'petty_cash_request' || $this->request_name == 'budget_request') {
                        return $approver_role_id == $this->max_role - 1;
                    }else {
                        return $approver_role_id == $this->max_role + 1;
                    }
                    break;  
                case 4:
                    break;
            };
            // if($this->request_name == 'petty_cash_request' || $this->request_name == 'budget_request' && $this->max_role != 2) {
            //     if($this->max_role == 4) {
            //         return $approver_role_id == $this->max_role - 1;
            //     }else {
            //         return $approver_role_id == $this->max_role + 2;
            //     }
            // }else{
            //     return $approver_role_id == $this->max_role + 2;
            // }
        }else{
            return $approver_role_id == $this->max_role + 1;
        }

    }
    public function updateRequest($editable, $data, $id) {
        
        if($this->isEditable($editable)){

            $res = response()->json($this->model->update($data, $id), 200);
            $employee_name = $this->getFullName();
            $prp_assigned_id = $this->getApproverId($this->request_name);
            $this->notifyNewRequest('edited', $employee_name, $prp_assigned_id, $this->request_name, $editable);

        }else{
            $res =  response()->json(['data'=>['message'=> 'you can\'t edit']], 400);
        }

        return $res;

    }

    public function notifyNewRequest($action, $user, $id, $type, $data) {

        return $this->user_request_service->notifyNewRequest($action, $user, $id, $type, $data);  

    }

    // public function storeRequest($data, $prp_assigned_id) {
    //     if($prp_assigned_id) {
    //         $res = response()->json($this->model->createRequest($data, $prp_assigned_id), 200);
    //         $employee_name = $this->getFullName($data['user_id']);
    //         $this->notifyNewRequest('added', $employee_name, $prp_assigned_id, $this->request_name);

    //     }else {

    //         $res = response()->json($this->model->create($data), 200);

    //     }

    //     return $res;

    // }

    public function storeRequest($data) {

        $res = $this->model->create($data);
        $employee_name = $this->getFullName();
        $prp_assigned_id = $this->getApproverId($this->request_name);
        if($this->request_name != 'Petty Cash Request' && $this->request_name != 'Budget Request') {
            $data = $res->load('user.assignedPrp');
        }else {
            $data = $res->load('user.assignedFinance');
        }
        $this->notifyNewRequest('added', $employee_name, $prp_assigned_id, $this->request_name, $data);

        return response()->json($res, 200);

    }

    public function showRequest($column, $id, $relationship) {

        return response()->json($this->model->getWhereWith($column, $id, $relationship), 200);

    }

    public function deleteRequest($id) {
        
        $prp_assigned_id = $this->getApproverId($this->request_name);
        $res = $this->model->delete($id);
        // dd($this->model->delete($id));
        $employee_name = $this->getFullName();
        // $this->notifyNewRequest('deleted', $employee_name, $prp_assigned_id, $this->request_name);

        return response()->json($res, 200);

    }

    public function getDepartmentId($id) {

        return $this->user->findWith($id, 'userInformation.department')->userInformation->department->id;

    }

    public function getFullName(){

        return $this->user_service->getFullName();

    }

    public function getPRPId(){
        
        return $this->user_service->getPRPId();

    }

    public function getApproverId($request_name){
        
        return $this->user_service->getApproverId($request_name);

    }
    
    
    // public function setPrpId($id) {

    //     return $id > 0 ? $id : 0;

    // }
    
}
