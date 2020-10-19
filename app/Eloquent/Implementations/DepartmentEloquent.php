<?php

namespace App\Eloquent\Implementations;

use App\Models\Department;  

class DepartmentEloquent extends EloquentImplementation {

  public function __construct(Department $department) {
    parent::__construct($department);
  }

}