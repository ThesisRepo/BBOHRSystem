<?php

namespace App\Services;

use App\Eloquent\Implementations\Requests\LeaveRequestEloquent;
use App\Eloquent\Implementations\Requests\ShiftChangeRequestEloquent;
use App\Eloquent\Implementations\Requests\OvertimeRequestEloquent;
use App\Eloquent\Implementations\Requests\BudgetRequestEloquent;
use App\Eloquent\Implementations\Requests\PettyCashRequestEloquent;
use App\Eloquent\Implementations\Requests\TravelAuthRequestEloquent;
use DateTime;

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
    // dd($with);
    $leave_request = $this->formatAllRequestPending($this->leave_request->with($with)->where('approver_role_id', 5)->where('status_id', 1)->orderBy('created_at', 'DESC')->get()->toArray(), 'leave_request');   
    if($leave_request) {
      array_push($temp_arr, ...$leave_request);
    }
    $shift_change_request = $this->formatAllRequestPending($this->shift_change_request->with($with)->where('approver_role_id', 5)->where('status_id', 1)->orderBy('created_at', 'DESC')->get()->toArray(), 'shift_change_request');
    // if() {
    //   array_push($temp_arr, ...$shift_change_request);
    // }
    $overtime_request = $this->formatAllRequestPending($this->overtime_request->with($with)->where('approver_role_id', 5)->where('status_id', 1)->orderBy('created_at', 'DESC')->get()->toArray(), 'overtime_request');
    // if() {
    //   array_push($temp_arr, ...$overtime_request);
    // }
    $budget_request = $this->formatAllRequestPending($this->budget_request->with($with)->where('approver_role_id', 5)->where('status_id', 1)->orderBy('created_at', 'DESC')->get()->toArray(), 'budget_request');
    $petty_cash_request = $this->formatAllRequestPending($this->petty_cash_request->with($with)->where('approver_role_id', 5)->where('status_id', 1)->orderBy('created_at', 'DESC')->get()->toArray(), 'petty_cash_request');
    $travel_auth_request = $this->formatAllRequestPending($this->travel_auth_request->with($with)->where('approver_role_id', 5)->where('status_id', 1)->orderBy('created_at', 'DESC')->get()->toArray(), 'travel_auth_request');
    // dd($budget_request);
    // if
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

  public function getAllFeedbackedDate($name, $start_date, $end_date, $status, $with = []) {

    $new_temp_date = $start_date;
    if($start_date != null && $end_date!=null) {
        if( new DateTime($new_temp_date) > new DateTime($end_date)) {
            $start_date = $end_date;
            $end_date = $new_temp_date;
        }
    }else {
        if($start_date == null) {
            $start_date = $end_date;
        }
        if($end_date == null) {
              $end_date = $start_date;
        }
    }
    switch($name) {
      case 'feedbacked_leave_requests':
          $model = $this->leave_request;
        break;
      case 'feedbacked_shift_change_requests':
          $model = $this->shift_change_request;
        break;
      case 'feedbacked_overtime_requests':
          $model = $this->overtime_request;
        break;
      case 'feedbacked_travel_auth_requests':
          $model = $this->travel_auth_request;
        break;
      case 'feedbacked_petty_cash_requests':
          $model = $this->petty_cash_request;
        break;
      case 'feedbacked_budget_requests':
          $model = $this->budget_request;
        break;
    }
    
    return $model->with($with)->whereDate('created_at','>=', $start_date)->whereDate('created_at','<=', $end_date)->where('status_id', $status)->orderBy('created_at', 'DESC')->get()->toArray();
  }

  public function getAllPendingPerRequest($name, $status, $with) {
    switch($name) {
      case 'leave_requests':
          $model = $this->leave_request;
        break;
      case 'shift_change_requests':
          $model = $this->shift_change_request;
        break;
      case 'overtime_requests':
          $model = $this->overtime_request;
        break;
      case 'travel_auth_requests':
          $model = $this->travel_auth_request;
        break;
      case 'petty_cash_requests':
          $model = $this->petty_cash_request;
        break;
      case 'budget_requests':
          $model = $this->budget_request;
        break;
    }
    
    return $model->whereWith('status_id', $status, $with)->orderBy('created_at', 'DESC')->get();
  }
}