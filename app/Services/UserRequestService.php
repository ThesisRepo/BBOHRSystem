<?php

namespace App\Services;
use App\Events\NewRequest;
use App\Events\NewCalendarEvent;

class UserRequestService 
{
  protected $notification;
  public function __construct() {
  }

  public function notifyNewRequest($action, $user, $id, $type, $data) {
    event(new NewRequest($action, $user, $id, $type, $data));
  }
  
  public function notifyNewEventCalendar($action, $user,$user_id, $data) {
    event(new NewCalendarEvent($action, $user,$user_id, $data));
  }
  
}