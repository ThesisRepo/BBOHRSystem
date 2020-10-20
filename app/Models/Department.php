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
    public function user_informations(){
        return hasMany(UserInformation::class);
    }

    public function leave_requests(){
        return hasMany(Requests\LeaveRequest::class);
    }

    public function shift_change_request(){
        return hasMany(Requests\ShiftChangeRequest::class);
    }

    public function petty_cash_request(){
        return hasMany(Requests\PettyCashRequest::class);
    }
}
