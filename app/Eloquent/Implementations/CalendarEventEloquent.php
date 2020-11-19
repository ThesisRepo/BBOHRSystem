<?php

namespace App\Eloquent\Implementations;

use App\Models\CalendarEvent;  

class CalendarEventEloquent extends EloquentImplementation {

  public function __construct(CalendarEvent $calendar_event) {
    parent::__construct($calendar_event);
  }

}