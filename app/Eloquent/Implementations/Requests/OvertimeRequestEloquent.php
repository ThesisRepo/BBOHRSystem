<?php

namespace App\Eloquent\Implementations\Requests;
use App\Models\Requests\OvertimeRequest;  

class OvertimeRequestEloquent extends EloquentRequestImplementation {

  public function __construct(OvertimeRequest $overtime_request) {
    parent::__construct($overtime_request);
  }

}