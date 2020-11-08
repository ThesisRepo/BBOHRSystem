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

    public function getPRPId() {
        $prp_assigned_id = Auth::user()->prp_assigned;    
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
}