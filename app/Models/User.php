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
        'first_name', 'last_name', 'email', 'password','prp_assigned', 'finance_mngr_assigned'
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
        return $this->hasMany(__CLASS__, 'prp_assigned');
    }

    /**
     * relationship of a pr and their subordinates
     * 
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function assignedPrp() {
        return $this->belongsTo(__CLASS__, 'prp_assigned');
    }

    public function subordinatesFinance() {
        return $this->hasMany(__CLASS__, 'finance_mngr_assigned');
    }

    /**
     * relationship of a pr and their subordinates
     * 
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function assignedFinance() {
        return $this->belongsTo(__CLASS__, 'finance_mngr_assigned');
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

    public function feedbacked_leave_requests() {
        return $this->morphedByMany(Requests\LeaveRequest::class, 'recordable');
    }

    public function shift_change_requests() {
        return $this->hasMany(Requests\ShiftChangeRequest::class);
    }

    public function feedbacked_shift_change_requests() {
        return $this->morphedByMany(Requests\ShiftChangeRequest::class, 'recordable');
    }

    public function overtime_requests() {
        return $this->hasMany(Requests\OvertimeRequest::class);
    }

    public function approved_overtime_requests() {
        return $this->morphedByMany(Requests\OvertimeRequest::class, 'recordable');
    }

    public function petty_cash_requests() {
        return $this->hasMany(Requests\PettyCashRequest::class);
    }

    public function approved_petty_cash_requests() {
        return $this->morphedByMany(Requests\PettyCashRequest::class, 'recordable');
    }

    public function budget_requests() {
        return $this->hasMany(Requests\PettyCashRequest::class);
    }
}
