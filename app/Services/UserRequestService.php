<?php

namespace App\Services;
use App\Events\NewRequest;

class UserRequestService 
{

  public function __construct() {
  }

  public function notifyNewRequest($action, $user, $type) {
    event(new NewRequest($action,$user,$type));
  }
}