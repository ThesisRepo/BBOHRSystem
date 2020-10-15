<?php

namespace App\Eloquent\Implementations\Requests;
use App\Eloquent\Implementations\EloquentImplementation;
use App\Models\Requests\LeaveRequest;  

class LeaveRequestEloquent extends EloquentImplementation {

  public function __construct(LeaveRequest $leave_request) {
    parent::__construct($leave_request);
  }

}