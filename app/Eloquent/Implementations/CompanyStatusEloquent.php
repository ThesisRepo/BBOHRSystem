<?php

namespace App\Eloquent\Implementations;

use App\Models\CompanyStatus;  

class CompanyStatusEloquent extends EloquentImplementation {

  public function __construct(CompanyStatus $company_status) {
    parent::__construct($company_status);
  }

}