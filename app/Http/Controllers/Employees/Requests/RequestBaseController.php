<?php

namespace App\Http\Controllers\Employees\Requests;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Eloquent\Implementations\RoleEloquent;
use App\Eloquent\Implementations\RequestDependencies\LeaveTypeEloquent;
use App\Eloquent\Implementations\UserEloquent;
use App\Eloquent\Implementations\Requests\EloquentRequestImplementation;

class RequestBaseController extends Controller
{

    protected $role;

    protected $user;

    protected $status;

    private $max_role;

    private $request_name;

    private $model;

    public function __construct(RoleEloquent $role, UserEloquent $user, EloquentRequestImplementation $model) {

        $this->middleware(['auth']);  
        $this->role = $role;
        $this->user = $user;
        $this->model = $model;

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
                return response()->json($this->model->updateRequest($data, $id, $prp_assigned_id), 200);
            }else {
                return response()->json($this->model->update($data, $id), 200);
            }
        }else{
            return response()->json([], 404);
        }
    }

    public function storeRequest($data, $prp_assigned_id) {
        if($prp_assigned_id) {
            return response()->json($this->model->createRequest($data, $prp_assigned_id), 200);
        }else {
            return response()->json($this->model->create($data), 200);
        }
    }

    public function showRequest($column, $id, $relationship) {
        return response()->json($this->model->getWhereWith($column, $id, $relationship), 200);
    }

    public function deleteRequest($id) {
        return response()->json($this->model->delete($id), 200);

    }
}
