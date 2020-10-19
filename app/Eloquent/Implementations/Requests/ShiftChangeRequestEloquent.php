<?php

namespace App\Eloquent\Implementations\Requests;
use App\Models\Requests\ShiftChangeRequest;  

class ShiftChangeRequestEloquent extends EloquentRequestImplementation {

  public function __construct(ShiftChangeRequest $shift_change_request) {
    parent::__construct($shift_change_request);
  }

}