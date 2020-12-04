<?php

namespace App\Eloquent\Implementations;

use App\Models\CivilStatus;  

class CivilStatusEloquent extends EloquentImplementation {

  public function __construct(CivilStatus $civil_status) {
    parent::__construct($civil_status);
  }

}