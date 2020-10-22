<?php

namespace App\Models\Requests;

use Illuminate\Database\Eloquent\Model;

class ShiftTime extends Model
{
    protected $fillable = [
        'shift_time_name'
    ];

    public function user_informations() {
        return $this->hasMany(UserInformation::class);
    }

    public function shift_change_request() {
        return $this->hasMany(ShiftChangeRequest::class);
    }
}
