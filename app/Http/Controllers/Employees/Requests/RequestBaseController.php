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
        }

        return $this->max_role; 

    }

    public function getDepartmentId($id) {

        return $this->user->findWith($id, 'userInformation.department')->userInformation->department->id;

    }

    public function getFullName($user_id){

        return $this->user_service->getFullName($user_id);

    }
    
    public function setPrpId($id) {

        return $id > 0 ? $id : 0;

    }

    public function isEditable($data) {

        if($data->status_id == 1) {
            $this->setMaxRoles($this->getRoles($data->user_id));
            $approver_role_id = $data->approver_role_id;
            $status_id = $data->status_id;
            if($this->request_name == 'petty_cash_request' || $this->request_name == 'budget_request' && $this->max_role != 2) {
                if($this->max_role == 4) {
                    return $approver_role_id == $this->max_role - 1;
                }else {
                    return $approver_role_id == $this->max_role + 2;
                }
            }else{
                return $approver_role_id == $this->max_role + 1;
            }
        }else{
            return $approver_role_id == $this->max_role + 1;
        }

    }

    public function updateRequest($editable, $data, $id, $prp_assigned_id) {
        
        if($this->isEditable($editable)){
            if($prp_assigned_id) {

                $res = response()->json($this->model->updateRequest($data, $id, $prp_assigned_id), 200);

            }else {

                $res = response()->json($this->model->update($data, $id), 200);

            }

            $employee_name = $this->getFullName($editable->user_id);
            $this->notifyNewRequest('edited', $employee_name, $prp_assigned_id, $this->request_name);

        }else{
            $res =  response()->json([], 404);
        }

        return $res;

    }

    public function notifyNewRequest($action, $user, $id, $type) {

        return $this->user_request_service->notifyNewRequest($action, $user, $id,$type);  

    }

    public function storeRequest($data, $prp_assigned_id) {

        if($prp_assigned_id) {

            $res = response()->json($this->model->createRequest($data, $prp_assigned_id), 200);
            $employee_name = $this->getFullName($data->user_id);
            $this->notifyNewRequest('added', $employee_name, $prp_assigned_id, $this->request_name);

        }else {

            $res = response()->json($this->model->create($data), 200);

        }

        return $res;

    }

    public function showRequest($column, $id, $relationship) {

        return response()->json($this->model->getWhereWith($column, $id, $relationship), 200);

    }

    public function deleteRequest($id) {

        $res = response()->json($this->model->delete($id), 200);

        $employee_name = $this->getFullName($data->user_id);
        $this->notifyNewRequest('added', $employee_name, $prp_assigned_id, $this->request_name);

        return $res;

    }
}
