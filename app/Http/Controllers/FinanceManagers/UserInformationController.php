<?php

namespace App\Http\Controllers\FinanceManagers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Eloquent\Implementations\UserEloquent;
use App\Services\UserService;
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
        $this->middleware(['auth', 'verify.manager.finance']);
        $this->user = $user;
        $this->user_service = $user_service;
        $this->all_user_request_service = $all_user_request_service;
    }


    public function getAllFeedbackedDatePettyCash(Request $request) {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $relationship = 'feedbacked_petty_cash_requests';
        $res = $this->all_user_request_service->getAllFeedbackedDate($relationship, $start_date, $end_date, 2);        
        return $res;
    }

    public function getAllFeedbackedDatePettyCashNegate(Request $request) {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $relationship = 'feedbacked_petty_cash_requests';
        $res = $this->all_user_request_service->getAllFeedbackedDate($relationship, $start_date, $end_date, 3);        
        return $res;
    }

    public function getAllFeedbackedDateBudget( Request $request) {
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
}
