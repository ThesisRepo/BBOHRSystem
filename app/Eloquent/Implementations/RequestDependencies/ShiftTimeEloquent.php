<?php

namespace App\Eloquent\Implementations\RequestDependencies;
use App\Eloquent\Implementations\EloquentImplementation;
use App\Models\Requests\ShiftTime;  

class ShiftTimeEloquent extends EloquentImplementation {

  public function __construct(ShiftTime $shift_time) {
    parent::__construct($shift_time);
  }

}