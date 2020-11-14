<?php

namespace App\Eloquent\Implementations;

use App\Models\CompanyPosition;  

class CompanyPositionEloquent extends EloquentImplementation {

  public function __construct(CompanyPosition $company_position) {
    parent::__construct($company_position);
  }

}