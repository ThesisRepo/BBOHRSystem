<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    
    /**
     * table name
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * Attribute that is mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'role_name'
    ];

    /**
     * Attribute that is not mass assignable
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * 
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function users() {
        return $this->belongsToMany(User::class, 'role_users')->withTimestamps();
    }

    public function leave_requests() {
        return $this->hasMany(Requests\LeaveRequest::class);
    }

    public function shift_change_requests() {
        return $this->hasMany(Requests\ShiftChangeRequest::class);
    }

    public function overtime_requests() {
        return $this->hasMany(Requests\OvertimeRequest::class);
    }

    public function petty_cash_requests() {
        return $this->hasMany(Requests\PettyCashRequest::class);
    }

    public function overriden_request() {
        return $this->hasOne(OverridenRequest::class);
    }
}
