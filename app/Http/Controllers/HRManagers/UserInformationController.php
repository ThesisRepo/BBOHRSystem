<?php

namespace App\Http\Controllers\HRManagers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Eloquent\Implementations\UserEloquent;
use App\Services\UserService;
use Hash;

class UserInformationController extends Controller
{

    protected $user;
    protected $user_service;

    public function __construct(
        UserEloquent $user,
        UserService $user_service
        ) {
        $this->middleware(['auth', 'verify.manager.hr']);
        $this->user = $user;
        $this->user_service = $user_service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->user->allWith(['userInformation', 'roles']);
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterRequest $request)
    {

        $user = [
            'prp_assigned' => $this->user_service->getPRPId(),
            'finance_mngr_assigned' => $this->user_service->getFinanceMngrAssignedId(),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' =>  Hash::make($request->password)
        ];
        $user_info = [
            'department_id' => $request->department_id,
            'shift_time_id' => $request->shift_time_id,
            'gender'=> $request->gender,
            'company_number' => $request->company_number,
            'profile_url' => $request->profile_url,
            'company_position' => $request->company_position,
            'date_hired' => $request->date_hired,
            'company_status' => $request->company_status,
            'birthday' => $request->birthday,
            'allowed_leave_number' => $request->allowed_leave_number,
            'address' => $request->address,
            'civil_status' => $request->civil_status,
            'contact_number' => $request->contact_number,
            'pag_ibig_number' => $request->pag_ibig_number,
            'sss_number' => $request->sss_number,
            'tin_number' => $request->tin_number,
            'philhealth_number' => $request->philhealth_number
        ];
        $role = [];

        switch($request->role_id) {
            case 1 :
                $role = [1];
                break;
            case 2:
                $role = [1, 2];
                break;
        }
        
        $res = $this->user->registerUser($user, $role, $user_info);

        return $res;

    }
    
    public function update(Request $request, $id)
    {
        $user = [
            'prp_assigned' => $this->user_service->getPRPId(),
            'finance_mngr_assigned' => $this->user_service->getFinanceMngrAssignedId(),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
        ];

        $user_info = [
            'department_id' => $request->department_id,
            'shift_time_id' => $request->shift_time_id,
            'gender'=> $request->gender,
            'company_number' => $request->company_number,
            'profile_url' => $request->profile_url,
            'company_position' => $request->company_position,
            'date_hired' => $request->date_hired,
            'company_status' => $request->company_status,
            'birthday' => $request->birthday,
            'allowed_leave_number' => $request->allowed_leave_number,
            'address' => $request->address,
            'civil_status' => $request->civil_status,
            'contact_number' => $request->contact_number,
            'pag_ibig_number' => $request->pag_ibig_number,
            'sss_number' => $request->sss_number,
            'tin_number' => $request->tin_number,
            'philhealth_number' => $request->philhealth_number
        ];

        $res = $this->user->updateUserWithInfo($id, $user, $user_info);  
        
        return $res;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */ 
    public function destroy($id)
    {
        $this->user->delete($id);
    }
}
