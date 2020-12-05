<?php

namespace App\Services;

use App\Eloquent\Implementations\Requests\LeaveRequestEloquent;
use App\Eloquent\Implementations\Requests\ShiftChangeRequestEloquent;
use App\Eloquent\Implementations\Requests\OvertimeRequestEloquent;
use App\Eloquent\Implementations\Requests\BudgetRequestEloquent;
use App\Eloquent\Implementations\Requests\PettyCashRequestEloquent;
use App\Eloquent\Implementations\Requests\TravelAuthRequestEloquent;

class AllUserRequestsService 
{

  protected $leave_request;
  
  protected $shift_change_request;
  
  protected $overtime_request;
  
  protected $budget_request;
  
  protected $petty_cash_request;

  protected $travel_auth_request;

  public function __construct( 
    LeaveRequestEloquent $leave_request,
    ShiftChangeRequestEloquent $shift_change_request,
    OvertimeRequestEloquent $overtime_request,
    BudgetRequestEloquent $budget_request,
    PettyCashRequestEloquent $petty_cash_request,
    TravelAuthRequestEloquent $travel_auth_request
  ) {
    $this->leave_request = $leave_request;
    $this->shift_change_request = $shift_change_request;
    $this->overtime_request = $overtime_request;   
    $this->budget_request = $budget_request;   
    $this->petty_cash_request = $petty_cash_request;
    $this->travel_auth_request = $travel_auth_request;
  }

  public function getAllPendingRequests($user) {
    return $this->leave_request->count();
  }
  public function getGMAllToApprove($with) {
    $temp_arr = [];
    array_push($temp_arr, ...$this->leave_request->with($with)->where('approver_role_id', 5)->where('status_id', 1)->get()->toArray());
    array_push($temp_arr, ...$this->shift_change_request->with($with)->where('approver_role_id', 5)->where('status_id', 1)->get()->toArray());
    array_push($temp_arr, ...$this->overtime_request->with($with)->where('approver_role_id', 5)->where('status_id', 1)->get()->toArray());
    array_push($temp_arr, ...$this->budget_request->with($with)->where('approver_role_id', 5)->where('status_id', 1)->get()->toArray());
    array_push($temp_arr, ...$this->petty_cash_request->with($with)->where('approver_role_id', 5)->where('status_id', 1)->get()->toArray());
    array_push($temp_arr, ...$this->travel_auth_request->with($with)->where('approver_role_id', 5)->where('status_id', 1)->get()->toArray());
    return $temp_arr;
  }
}