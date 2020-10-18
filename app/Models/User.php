<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password','prp_assigned'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * relationship of roles to employees
     * 
     *@return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function roles() {
        return $this->belongsToMany(Role::class, 'role_users')->withTimestamps();
    }

    /**
     * relationship of a pr and their subordinates
     * 
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function subordinates() {
        return $this->hasMany('__CLASS__', 'prp_assigned');
    }

    /**
     * relationship of a pr and their subordinates
     * 
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function assignedPrp() {
        return $this->belongsTo('__CLASS__', 'prp_assigned');
    }

    /**
     * relationship of user to its information
     * 
     * @return \Illuminate\Databas\Eloquent\Relations\hasOne
     */
    public function userInformation() {
        return $this->hasOne(UserInformation::class);
    }
    
    public function leave_requests() {
        return $this->hasMany(Requests\LeaveRequest::class);
    }

    public function approved_leave_requests() {
        return $this->morphByMany(Requests\LeaveRequest::class, 'approved_request_records');
    }

    public function shift_change_requests() {
        return $this->hasMany(Requests\ShiftChangeRequest::class);
    }

    public function approved_shift_change_equests() {
        return $this->morphByMany(Requests\ShiftChangeRequest::class, 'approved_request_records');
    }

    public function overtime_requests() {
        return $this->hasMany(Requests\OvertimeRequest::class);
    }

    public function approved_overtime_requests() {
        return $this->morphByMany(Requests\OvertimeRequest::class, 'approved_request_records');
    }

    public function petty_cash_requests() {
        return $this->hasMany(Requests\PettyCashRequest::class);
    }

    public function approved_petty_cash_requests() {
        return $this->morphByMany(Requests\PettyCashRequest::class, 'approved_request_records');
    }
}
