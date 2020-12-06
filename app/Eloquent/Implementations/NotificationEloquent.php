<?php

namespace App\Eloquent\Implementations;

use App\Models\Notification;  

class NotificationEloquent extends EloquentImplementation {

  public function __construct(Notification $notification) {
    parent::__construct($notification);
  }

}