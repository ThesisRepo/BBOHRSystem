<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Schedulable;

class CalendarEvent extends Model
{

    use Schedulable;

    protected $fillable  = [
        'user_id',
        'title',
        'content',
        'start_date',
        'end_date',
        'is_public',
        'event_type_id',
        'is_yearly'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function event_type() {
        return $this->belongsTo(EventType::class)->withTrashed();
    }

    public function due_event() {
        $this->timezone = 'Asia/Manila';
        $calendar = $this->all()->load(['user', 'event_type'])->filter(function($q) {
            $isDue = false;
            $due_time = $q->start_date;
            $due_in_24_hour_format  = date("G", strtotime($due_time));
            $due_in_minute_format  = date("i", strtotime($due_time));
            $due_in_day_format  = date("d", strtotime($due_time));
            $due_in_month_format  = date("m", strtotime($due_time));
            $due_in_year_format  = date("Y", strtotime($due_time));
            // dd($due_in_24_hour_format, $due_in_minute_format, $due_in_day_format, $due_in_month_format ,$due_in_year_format );
            // $this->expression = $due_in_minute_format . ' ' . $due_in_24_hour_format . ' ' .$due_in_day_format . ' ' . $due_in_month_format. ' * ';
            $this->expression = $due_in_minute_format . ' ' . $due_in_24_hour_format . ' ' .$due_in_day_format . ' ' . $due_in_month_format. ' * ';            
            if( $this->isDue()){
                $isDue = true;
                return $isDue;
            }
          return $isDue;
        });   
        return $calendar;
    }
}
