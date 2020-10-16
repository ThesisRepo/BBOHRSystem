<?php

namespace App\Eloquent\Implementations\RequestDependencies;
use App\Eloquent\Implementations\EloquentImplementation;
use App\Models\Requests\LeaveType;  

class LeaveTypeEloquent extends EloquentImplementation {

  public function __construct(LeaveType $leave_type) {
    parent::__construct($leave_type);
  }

}