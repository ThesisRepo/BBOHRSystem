<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyPosition extends Model
{
    protected $fillable = [
        'position_name'
    ];
    public function userInformation() {
        return $this->belongstoMany(UserInformation::class, 'user_company_positions')->withTimestamps();
    }
}
