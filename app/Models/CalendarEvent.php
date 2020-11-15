<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalendarEvent extends Model
{
    protected $fillable  = [
        'title',
        'content',
        'start_date',
        'end_date',
        'is_private'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function event_type() {
        return $this->belongsTo(EventType::class);
    }
}
