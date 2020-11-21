<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'request_type',
        'message',
        'is_seen'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
