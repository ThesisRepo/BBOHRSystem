<?php

namespace App\Eloquent\Implementations\Requests;
use App\Models\Requests\TravelAuthRequest;  

class TravelAuthRequestEloquent extends EloquentRequestImplementation {

  public function __construct(TravelAuthRequest $budget_request) {
    parent::__construct($budget_request);
  }
}