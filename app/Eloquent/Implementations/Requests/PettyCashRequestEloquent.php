<?php

namespace App\Eloquent\Implementations\Requests;
use App\Models\Requests\PettyCashRequest;  

class PettyCashRequestEloquent extends EloquentRequestImplementation {

  public function __construct(PettyCashRequest $petty_cash_request) {
    parent::__construct($petty_cash_request);
  }
}