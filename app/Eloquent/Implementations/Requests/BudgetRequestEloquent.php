<?php

namespace App\Eloquent\Implementations\Requests;
use App\Models\Requests\BudgetRequest;  

class BudgetRequestEloquent extends EloquentRequestImplementation {

  public function __construct(BudgetRequest $budget_request) {
    parent::__construct($budget_request);
  }
}