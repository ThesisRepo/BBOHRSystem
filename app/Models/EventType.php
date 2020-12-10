<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventType extends Model
{
    use SoftDeletes;
    
    protected $fillable  = [
        'event_name',
        'color',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function calendar_events() {
        return $this->hasMany(CalendarEvent::class);
    }
}
