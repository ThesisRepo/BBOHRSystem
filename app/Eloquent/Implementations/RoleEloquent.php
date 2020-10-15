<?php

namespace App\Eloquent\Implementations;

use App\Models\Role;  

class RoleEloquent extends EloquentImplementation {

  public function __construct(Role $role) {
    parent::__construct($role);
  }

}