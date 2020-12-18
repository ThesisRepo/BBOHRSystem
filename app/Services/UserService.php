<?php

namespace App\Services;

use App\Eloquent\Implementations\RoleEloquent;
use App\Eloquent\Implementations\UserEloquent;
use Auth;

class UserService 
{
    protected $role;

    public $user;

    public function __construct(RoleEloquent $role, UserEloquent $user) {
        $this->role = $role;
        $this->user = $user;
    }

    public function getMaxRoles($roleArr) {

     $max_role = 0;
     foreach( $roleArr as  $datum) {
         $max_role = $datum->id > $max_role ? $datum->id : $max_role;
     }

     return $max_role;

    }

    public function getFullName() {

        $user = Auth::user();
        $full_name = $user->first_name . ' ' . $user->last_name;

        return $full_name;
        
    }

    public function getFullNameWithParams($first_name, $last_name) {
        $full_name = $first_name . ' ' . $last_name;
        return $full_name;
    }

    public function getPRPId() {
        $prp_assigned_id = Auth::user()->prp_assigned;    
        return $prp_assigned_id;
    }

    public function getApproverId($request_type) {
        if($request_type != 'Petty Cash Request' && $request_type != 'Budget Request') {
            $prp_assigned_id = Auth::user()->prp_assigned;    
        } else {
            $prp_assigned_id = Auth::user()->finance_mngr_assigned;    
        }
        return $prp_assigned_id;
    }
    public function getFinanceMngrAssignedId() {
        $finance_mngr_assigned_id = Auth::user()->finance_mngr_assigned;     
        return $finance_mngr_assigned_id;
    }

    public function getUserId() {
        $user_id = Auth::user()->id;
        return $user_id;
    }
    
    public function getAuth() {
        $res = Auth::user();
        return $res;
    }

    public function getUserInformation() {
        $res = Auth::user()->userInformation;
        return $res;
    }

    public function getShiftTime() {
        $res = Auth::user();
        return $res;
    }

    public function findUserWith($user_id, $with) {
        $res = $this->user->findWith($user_id, $with);
        return $res;
    }

    public function whereNotAdminUserWith($role_id, $with) {
        $res = $this->user->whereDoesntHaveWhereIn('roles','roles.id', 6)->whereHas('roles', function($q) use($role_id) {
            return $q->where('roles.id', $role_id);
        })->first();
        // dd($res->toArray());
        return $res;
    }


    public function hasUserInformation() {
        return $this->getUserInformation() != null;
    }
}