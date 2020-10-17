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
    
    public function __construct(RoleEloquent $role, LeaveTypeEloquent $leave_type, UserEloquent $user ) {

        $this->middleware(['auth']);  
        $this->role = $role;
        $this->leave_type = $leave_type;
        $this->user = $user;

    }
    public function getRoles($id) {
        return $this->user->findWith($id, 'roles')->roles;
    }
    public function nextApproverId($id, $request_name) {
        $max_role = 0;
        $data = $this->getRoles($id);

        foreach( $data as  $datum) {
            $max_role = $datum->id > $max_role ? $datum->id : $max_role;
        }
        
        if($request_name == 'petty_cash_request' || $request_name == 'petty_cash_request') {
            if($max_role == 3 || $max_role == 1) {
                $max_role ++;
            }else if($max_role == 4) {
                $max_role --;
            }
        }else {
            $max_role ++;
        }
        return $max_role;
    }


}
