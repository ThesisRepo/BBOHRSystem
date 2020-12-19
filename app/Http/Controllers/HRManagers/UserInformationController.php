<?php

namespace App\Http\Controllers\HRManagers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Eloquent\Implementations\UserEloquent;
use App\Services\UserService;
use Hash;
use DateTime;
use App\Traits\CallForActionEmail;
use App\Services\AllUserRequestsService;

class UserInformationController extends Controller
{
    use CallForActionEmail;
    
    protected $user;
    protected $user_service;
    protected $all_user_request_service;

    public function __construct(
        UserEloquent $user,
        UserService $user_service,
        AllUserRequestsService $all_user_request_service
        ) {
        $this->middleware(['auth', 'verify.manager.hr']);
        $this->user = $user;
        $this->user_service = $user_service;
        $this->all_user_request_service = $all_user_request_service;

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
            // 'prp_assigned' => $this->user_service->getPRPId(),
            // 'finance_mngr_assigned' => $this->user_service->getFinanceMngrAssignedId(),
            'prp_assigned' => $request->prp_assigned,
            'finance_mngr_assigned' => $request->finance_assigned,
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
            'date_hired' => $request->date_hired,
            'company_status_id' => $request->company_status_id,
            'regularization_date' => $request->regularization_date,
            'birthday' => $request->birthday,
            'allowed_leave_number' => $request->allowed_leave_number,
            'address' => $request->address,
            'civil_status_id' => $request->civil_status_id,
            'contact_number' => $request->contact_number,
            'pag_ibig_number' => $request->pag_ibig_number,
            'sss_number' => $request->sss_number,
            'tin_number' => $request->tin_number,
            'philhealth_number' => $request->philhealth_number
        ];

        $company_position = $request->company_position;

        $role = [];

        switch($request->role_id) {
            case 1 :
                $role = [1];
                break;
            case 2:
                $role = [1, 2];
                break;
        }    
        try {
            $res = $this->user->registerUser($user, $role, $user_info, $company_position);
            // dd($res->makeVisible(['password'])->toArray());
            $this->sendVerificationEmailOnRegister($res);
            // $link = str_random(30);
            // $activation_data = [
            //     'user_id' => $user_id,
            //     'token' => $link
            // ];
            // $acc = DB::table('user_acc_activations')->insert($activation_data);
            // Mail::send('emails/user-acc-activation', ['user' => $activation_data], function ($m) use ($user) {
            //     $m->to($user['email'])->subject('BBO Request Management Password!');
            // });
            return $res;
        }catch(\Exception $e) {
            return $e;
        }

    }

    public function update(Request $request, $id)
    {
        $prp = ['prp_assigned' => $request->prp_assigned];
        $user = [
            // 'prp_assigned' => $this->user_service->getPRPId(),
            // 'finance_mngr_assigned' => $this->user_service->getFinanceMngrAssignedId(),
            'finance_mngr_assigned' => $request->finance_assigned,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
        ];
        if($request->prp_assigned !== null){
            array_push($user, $prp);
        }
        if($request->password) {
            $user['password'] = $request->password;
        }
        $user_info = [
            'department_id' => $request->department,
            'shift_time_id' => $request->shift_time,
            'gender'=> $request->gender,
            'company_number' => $request->company_number,
            'date_hired' => $request->date_hired,
            'company_status' => $request->company_status,
            'regularization_date' => $request->regularization_date,
            'birthday' => $request->birthday,
            'allowed_leave_number' => $request->allowed_leave_number,
            'address' => $request->address,
            'civil_status_id' => $request->civil_status_id,
            'contact_number' => $request->contact_number
        ];
        $company_position = $request->company_position;
        return $this->user->updateUserWithInfo($id, $user, $user_info, $company_position['id']);        
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

    public function resetPasswordOfUser( Request $request, $id) {
        $password = Hash::make($request->password);
        $data = [
            'password' => $password
        ];
    }

    public function getAllFeedbackedDateLeave( Request $request) {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $relationship = 'feedbacked_leave_requests';
        $with = ['user', 'leave_type'];
        $res = $this->all_user_request_service->getAllFeedbackedDate($relationship, $start_date, $end_date, 2, $with);
        return $res;
    }

    public function getAllFeedbackedDateLeaveNegate( Request $request) {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $relationship = 'feedbacked_leave_requests';
        $with = ['user', 'leave_type'];
        $res = $this->all_user_request_service->getAllFeedbackedDate($relationship, $start_date, $end_date, 3, $with);
        return $res;
    }

    public function getAllFeedbackedDateShiftChange( Request $request) {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $relationship = 'feedbacked_shift_change_requests';
        $with = ['user', 'shift_time'];
        $res = $this->all_user_request_service->getAllFeedbackedDate($relationship, $start_date, $end_date, 2, $with);
        return $res;
    }
    
    public function getAllFeedbackedDateShiftChangeNegate( Request $request) {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $relationship = 'feedbacked_shift_change_requests';
        $with = ['user', 'shift_time'];
        $res = $this->all_user_request_service->getAllFeedbackedDate($relationship, $start_date, $end_date, 3, $with);
        return $res;
    }

    public function getAllFeedbackedDateOvertime( Request $request) {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $relationship = 'feedbacked_overtime_requests';
        $with = ['user'];
        $res = $this->all_user_request_service->getAllFeedbackedDate($relationship, $start_date, $end_date, 2, $with);        
        return $res;
    }

    public function getAllFeedbackedDateOvertimeNegate( Request $request) {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $relationship = 'feedbacked_overtime_requests';
        $with = ['user'];
        $res = $this->all_user_request_service->getAllFeedbackedDate($relationship, $start_date, $end_date, 3, $with);        
        return $res;
    }

    public function getAllFeedbackedDateTravelAuth( Request $request) {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $relationship = 'feedbacked_travel_auth_requests';
        $with = ['user'];
        $res = $this->all_user_request_service->getAllFeedbackedDate($relationship, $start_date, $end_date, 2, $with);
        return $res;
    }

    public function getAllFeedbackedDateTravelAuthNegate( Request $request) {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $relationship = 'feedbacked_travel_auth_requests';
        $with = ['user'];
        $res = $this->all_user_request_service->getAllFeedbackedDate($relationship, $start_date, $end_date, 3, $with);
        return $res;
    }

    public function getAllFeedbackedDatePettyCash($user_id, Request $request) {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $relationship = 'feedbacked_petty_cash_requests';
        $res = $this->all_user_request_service->getAllFeedbackedDate($relationship, $start_date, $end_date, 2);        
        return $res;
    }

    public function getAllFeedbackedDatePettyCashNegate($user_id, Request $request) {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $relationship = 'feedbacked_petty_cash_requests';
        $res = $this->all_user_request_service->getAllFeedbackedDate($relationship, $start_date, $end_date, 3);        
        return $res;
    }

    public function getAllFeedbackedDateBudget($user_id, Request $request) {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $relationship = 'feedbacked_budget_requests';
        $res = $this->all_user_request_service->getAllFeedbackedDate($relationship, $start_date, $end_date, 2);        
        return $res;
    }

    public function getAllFeedbackedDateBudgetNegate($user_id, Request $request) {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $relationship = 'feedbacked_budget_requests';
        $res = $this->all_user_request_service->getAllFeedbackedDate($relationship, $start_date, $end_date, 3);        
        return $res;
    }

    // public function getAllFeedbackedDate( $table_name, $relationship, $start_date, $end_date, $user_id = null) {
    //     $user_id = $user_id ? $user_id: $this->user_service->getUserId();
    //     $new_temp_date = $start_date;
    //     if($start_date != null && $end_date!=null) {
    //         if( new DateTime($new_temp_date) > new DateTime($end_date)) {
    //             $start_date = $end_date;
    //             $end_date = $new_temp_date;
    //         }
    //     }else {
    //         if($start_date == null) {
    //             $start_date = $end_date;
    //         }
    //         if($end_date == null) {
    //              $end_date = $start_date;
    //         }
    //     }
        // $res = $this->user->getRequestFeedbackedDate( $user_id, $table_name, $relationship, $start_date, $end_date);  
    //     return $res;
    // }

}
