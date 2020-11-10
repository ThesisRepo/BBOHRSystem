<?php

namespace App\Http\Controllers\HRManagers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Eloquent\Implementations\UserEloquent;
use App\Services\UserService;
use Hash;
use DateTime;

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
        return $this->user->getAllNonAdminEmployees();
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterRequest $request)
    {
        // login na ni diri 
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
            'regularization_date' => $request->regularization_date,
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
        
        return $this->user->registerUser($user, $role, $user_info);

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
        if($request->password) {
            $user['password'] = $request->password;
        }
        $user_info = [
            'department_id' => $request->department_id,
            'shift_time_id' => $request->shift_time_id,
            'gender'=> $request->gender,
            'company_number' => $request->company_number,
            'profile_url' => $request->profile_url,
            'company_position' => $request->company_position,
            'date_hired' => $request->date_hired,
            'company_status' => $request->company_status,
            'regularization_date' => $request->regularization_date,
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

        return $this->user->updateUserWithInfo($id, $user, $user_info);        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $this->user->delete($id);
    }

    public function getAllFeedbackedDateLeave( Request $request) {
        $table_name = $this->user->getTableFeedbackedLeaveRequests();
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $relationship = 'feedbacked_leave_requests';
        $res = $this->getAllFeedbackedDate( $table_name, $relationship, $start_date, $end_date);
        return $res;
    }

    public function getAllFeedbackedDateShiftChange( Request $request) {
        $table_name = $this->user->getTableFeedbackedShiftChangeRequests();
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $relationship = 'shift_change_requests';
        $res = $this->getAllFeedbackedDate( $table_name, $relationship, $start_date, $end_date);
        return $res;
    }

    public function getAllFeedbackedDateOvertime( Request $request) {
        $table_name = $this->user->getTableFeedbackedOvertimeRequests();
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $relationship = 'feedbacked_overtime_requests';
        $res = $this->getAllFeedbackedDate( $table_name, $relationship, $start_date, $end_date);
        return $res;
    }

    public function getAllFeedbackedDateTravelAuth( Request $request) {
        $table_name = $this->user->getTableFeedbackedTravelAuthRequests();
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $relationship = 'feedbacked_travel_auth_requests';
        $res = $this->getAllFeedbackedDate( $table_name, $relationship, $start_date, $end_date);
        return $res;
    }

    public function getAllFeedbackedDatePettyCash($user_id, Request $request) {
        $table_name = $this->user->getTableFeedbackedPettyCashRequests();
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $relationship = 'feedbacked_petty_cash_requests';
        $res = $this->getAllFeedbackedDate( $table_name, $relationship, $start_date, $end_date, $user_id);
        return $res;
    }

    public function getAllFeedbackedDateBudget($user_id, Request $request) {
        $table_name = $this->user->getTableFeedbackedBudgetRequests();
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $relationship = 'feedbacked_budget_requests';
        $res = $this->getAllFeedbackedDate( $table_name, $relationship, $start_date, $end_date, $user_id);
        return $res;
    }

    public function getAllFeedbackedDate( $table_name, $relationship, $start_date, $end_date, $user_id = null) {

        $user_id = $user_id ? $user_id: $this->user_service->getUserId();
        $new_temp_date = $start_date;
        if( new DateTime($new_temp_date) > new DateTime($end_date)) {
            $start_date = $end_date;
            $end_date = $new_temp_date;
        }
        $res = $this->user->getRequestFeedbackedDate( $user_id, $table_name, $relationship, $start_date, $end_date);
        
        return $res;
        
    }

}
