<?php

namespace App\Services;

use App\Eloquent\Implementations\RoleEloquent;
use App\Eloquent\Implementations\UserEloquent;

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

    public function getFullName($id) {

        $user = $this->user->find($id);
        $full_name = $user->first_name . ' ' . $user->last_name;
        
        return $full_name;
    }
}