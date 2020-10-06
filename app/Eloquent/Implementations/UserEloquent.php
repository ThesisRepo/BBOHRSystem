<?php

namespace App\Eloquent\Implementations;

use App\Eloquent\Implementations\EloquentImplementation;
use App\Models\User;  

class UserEloquent extends EloquentImplementation {  

    public function __construct(User $user) {
      parent::__construct($user);
    }

    public function isRoleExisting($id) {
      return $this->model->where('role_id', $id)->first();
    }
}