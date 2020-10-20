<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShiftTime extends Model
{
    protected $fillable = [
        'shift_time_name'
    ];

    public function user_informations() {
        return $this->hasMany(UserInformation::class);
    }
}
