<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';
    protected $fillable = [
        'department_name'
    ];

    /**
     * Relationship of department to  user informations
     * 
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function userInformations(){
        return $this->hasMany(UserInformation::class);
    }

    public function leave_requests(){
        return $this->hasMany(Requests\LeaveRequest::class);
    }

    public function shift_change_request(){
        return $this->hasMany(Requests\ShiftChangeRequest::class);
    }

    public function petty_cash_request(){
        return $this->hasMany(Requests\PettyCashRequest::class);
    }
}
