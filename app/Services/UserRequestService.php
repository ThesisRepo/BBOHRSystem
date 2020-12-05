<?php

namespace App\Services;
use App\Events\NewRequest;

class UserRequestService 
{
  protected $notification;
  public function __construct() {
  }

  public function notifyNewRequest($action, $user, $id, $type, $data) {
    event(new NewRequest($action, $user, $id, $type, $data));
  }
  
  
}