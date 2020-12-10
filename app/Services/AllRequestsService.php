<?php
namespace App\Services;

class AllRequestsService extends AllUserRequestsService
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
    parent::__construct(
      $leave_request, $shift_change_request, $overtime_request, $budget_request, $petty_cash_request, $travel_auth_request
    );

  }

  public function getAllPendingRequests($user) {
    return $this->leave_request->count();
  }
}