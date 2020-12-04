<?php

namespace App\Eloquent\Implementations;

use App\Models\EventType;  

class EventTypeEloquent extends EloquentImplementation {

  public function __construct(EventType $event_type) {
    parent::__construct($event_type);
  }

}