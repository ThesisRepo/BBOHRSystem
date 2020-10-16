<?php

namespace App\Eloquent\Implementations\Requests;
use App\Models\Requests\LeaveRequest;  

class LeaveRequestEloquent extends EloquentRequestImplementation {

  public function __construct(LeaveRequest $leave_request) {
    parent::__construct($leave_request);
  }

}