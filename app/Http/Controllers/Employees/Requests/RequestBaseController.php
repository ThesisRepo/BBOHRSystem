<?php

namespace App\Http\Controllers\Employees\Requests;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Eloquent\Implementations\RoleEloquent;
use App\Eloquent\Implementations\RequestDependencies\LeaveTypeEloquent;
use App\Eloquent\Implementations\UserEloquent;


class RequestBaseController extends Controller
{

    protected $role;
    
    protected $leave_type;

    protected $user;

    protected $status;

    private $max_role;

    private $request_name;

    public function __construct(RoleEloquent $role, LeaveTypeEloquent $leave_type, UserEloquent $user ) {

        $this->middleware(['auth']);  
        $this->role = $role;
        $this->leave_type = $leave_type;
        $this->user = $user;

    }
    public function getRoles($id) {
        return $this->user->findWith($id, 'roles')->roles;
    }

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

    public function nextApproverId($id, $request_name) {

        $this->setMaxRoles($this->getRoles($id));

        if($this->request_name == 'petty_cash_request' || $this->request_name == 'petty_cash_request' && $this->max_role != 2) {
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

    public function isEditable($data) {
        if($data->status_id == 1) {
            $this->setMaxRoles($this->getRoles($data->user_id));
            $approver_role_id = $data->approver_role_id;
            $status_id = $data->status_id;
            if($this->request_name == 'petty_cash_request' || $this->request_name == 'petty_cash_request' && $this->max_role != 2) {
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

}
