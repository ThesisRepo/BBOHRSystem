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
  public function formatAllRequestPending($data, $type) {
    return array_map(function($el) use($type){
      switch ($type) {
        case 'leave_request':
          $el['request_type']= $this->leave_request->getTableName();
          break;
        case 'shift_change_request':
          $el['request_type']= $this->shift_change_request->getTableName();
          break;
        case 'overtime_request':
          $el['request_type']= $this->overtime_request->getTableName();
          break;
          case 'budget_request':
          $el['request_type']= $this->budget_request->getTableName();
          break;
        case 'petty_cash_request':
          $el['request_type']= $this->petty_cash_request->getTableName();
          break;
        case 'travel_auth_request':
          $el['request_type']= $this->travel_auth_request->getTableName();
          break;
      }
          return $el;
        },$data);
  }
  public function getGMAllToApprove($with) {
    $temp_arr = [];
    $leave_request = $this->formatAllRequestPending($this->leave_request->with($with)->where('approver_role_id', 5)->where('status_id', 1)->orderBy('created_at', 'DESC')->get()->toArray(), 'leave_request');    
    $shift_change_request = $this->formatAllRequestPending($this->shift_change_request->with($with)->where('approver_role_id', 5)->where('status_id', 1)->orderBy('created_at', 'DESC')->get()->toArray(), 'shift_change_request');
    $overtime_request = $this->formatAllRequestPending($this->overtime_request->with($with)->where('approver_role_id', 5)->where('status_id', 1)->orderBy('created_at', 'DESC')->get()->toArray(), 'overtime_request');
    $budget_request = $this->formatAllRequestPending($this->budget_request->with($with)->where('approver_role_id', 5)->where('status_id', 1)->orderBy('created_at', 'DESC')->get()->toArray(), 'budget_request');
    $petty_cash_request = $this->formatAllRequestPending($this->petty_cash_request->with($with)->where('approver_role_id', 5)->where('status_id', 1)->orderBy('created_at', 'DESC')->get()->toArray(), 'petty_cash_request');
    $travel_auth_request = $this->formatAllRequestPending($this->travel_auth_request->with($with)->where('approver_role_id', 5)->where('status_id', 1)->orderBy('created_at', 'DESC')->get()->toArray(), 'travel_auth_request');
    array_push($temp_arr, ...$leave_request);
    array_push($temp_arr, ...$shift_change_request);
    array_push($temp_arr, ...$overtime_request);
    array_push($temp_arr, ...$budget_request);
    array_push($temp_arr, ...$petty_cash_request);
    array_push($temp_arr, ...$travel_auth_request);
    return $temp_arr;
  }

  public function getAllPending($with) {
    $temp_arr = [];
    $leave_request = $this->formatAllRequestPending($this->leave_request->with($with)->where('status_id', 1)->orderBy('created_at', 'DESC')->get()->toArray(), 'leave_request');    
    $shift_change_request = $this->formatAllRequestPending($this->shift_change_request->with($with)->where('status_id', 1)->orderBy('created_at', 'DESC')->get()->toArray(), 'shift_change_request');
    $overtime_request = $this->formatAllRequestPending($this->overtime_request->with($with)->where('status_id', 1)->orderBy('created_at', 'DESC')->get()->toArray(), 'overtime_request');
    $budget_request = $this->formatAllRequestPending($this->budget_request->with($with)->where('status_id', 1)->orderBy('created_at', 'DESC')->get()->toArray(), 'budget_request');
    $petty_cash_request = $this->formatAllRequestPending($this->petty_cash_request->with($with)->where('status_id', 1)->orderBy('created_at', 'DESC')->get()->toArray(), 'petty_cash_request');
    $travel_auth_request = $this->formatAllRequestPending($this->travel_auth_request->with($with)->where('status_id', 1)->orderBy('created_at', 'DESC')->get()->toArray(), 'travel_auth_request');
    array_push($temp_arr, ...$leave_request);
    array_push($temp_arr, ...$shift_change_request);
    array_push($temp_arr, ...$overtime_request);
    array_push($temp_arr, ...$budget_request);
    array_push($temp_arr, ...$petty_cash_request);
    array_push($temp_arr, ...$travel_auth_request);
    return $temp_arr;
  }
}