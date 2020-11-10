<?php

namespace App\Services;

use App\Eloquent\Implementations\RoleEloquent;
use App\Eloquent\Implementations\RequestDependencies\LeaveTypeEloquent;
use App\Eloquent\Implementations\UserEloquent;
use App\Models\Recordable;

class ApproverRequestService 
{
    protected $role;

    public $user;

    protected $status;

    protected $recordable;

    private $request_name;

    protected $request_type;

    public function __construct(RoleEloquent $role, UserEloquent $user) {
        $this->role = $role;
        $this->user = $user;
    }

    public function setRequestType($request_type) {

         $this->request_type = $request_type;
    }

    public function getUserRoles($user_id){

        return $this->user->findWith($user_id, 'roles');

    }

    public function getMaxRoles($roleArr) {

        $max_role = 0;
        foreach( $roleArr as  $datum) {
            $max_role = $datum->id > $max_role ? $datum->id : $max_role;
        }

        return $max_role;

    }

    public function getNextApprover($max_role_id) {
        switch($max_role_id){
            case 2:

                $max_role_id ++;    
                if($this->request_type != 'budget_request' && $this->request_type != 'petty_cash_request') {
                    $max_role_id ++;
                }

                return $max_role_id; 
                break;

            case 3:

                return $max_role_id += 2;
                break;

            default:
                $max_role_id++;   
                return $max_role_id;
                break;
            
        }
    }

    public function getAllFeedbackedRequest($user_id, $relationship, $nested_relationship){
        
        return $this->user->getAllFeedbackedRequests($user_id, $relationship, $nested_relationship);
    
    }

    public function getAllDisapprovedRequest($user_id, $relationship){

        return $this->user->getAllDisapprovedRequest($user_id, $relationship);
    
    }

    public function getAllApprovedRequest($user_id, $relationship, $isFinal = false){

        return $this->user->getAllApprovedRequest($user_id, $relationship, $isFinal);
    
    }
}