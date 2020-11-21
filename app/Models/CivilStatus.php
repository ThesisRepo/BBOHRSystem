<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CivilStatus extends Model
{

    protected $table = "civil_status";
    
    protected $fillable = [
        'civil_status_name'
    ];

    public function user() {
        return $this->hasOne(UserInformation::class);
    }
}
