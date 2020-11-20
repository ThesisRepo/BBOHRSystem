<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 
        'last_name', 'email', 'password','prp_assigned',
         'finance_mngr_assigned', 'google_id',
         'email_verified_at'
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

    public function user_acc_activation() {
        return $this->hasOne(UserAccActivation::class);
    }
    
    public function leave_requests() {
        return $this->hasMany(Requests\LeaveRequest::class);
    }

    public function feedbacked_leave_requests() {
        return $this->morphedByMany(Requests\LeaveRequest::class, 'recordable');
    }
    
    // public function recorded_leave_requests() {
    //     return $this->morphedByMany(Requests\LeaveRequest::class, 'requestable');
    // }



    public function shift_change_requests() {
        return $this->hasMany(Requests\ShiftChangeRequest::class);
    }

    public function feedbacked_shift_change_requests() {
        return $this->morphedByMany(Requests\ShiftChangeRequest::class, 'recordable');
    }

    // public function recorded_shift_change_requests() {
    //     return $this->morphedByMany(Requests\ShiftChangeRequest::class, 'requestable');
    // }



    public function overtime_requests() {
        return $this->hasMany(Requests\OvertimeRequest::class);
    }

    public function feedbacked_overtime_requests() {
        return $this->morphedByMany(Requests\OvertimeRequest::class, 'recordable');
    }

    // public function recorded_overtime__requests() {
    //     return $this->morphedByMany(Requests\OvertimeRequest::class, 'requestable');
    // }



    public function petty_cash_requests() {
        return $this->hasMany(Requests\PettyCashRequest::class);
    }

    public function feedbacked_petty_cash_requests() {
        return $this->morphedByMany(Requests\PettyCashRequest::class, 'recordable');
    }

    // public function recorded_petty_cash_requests() {
    //     return $this->morphedByMany(Requests\PettyCashRequest::class, 'requestable');
    // }



    public function budget_requests() {
        return $this->hasMany(Requests\BudgetRequest::class);
    }

    public function feedbacked_budget_requests() {
        return $this->morphedByMany(Requests\BudgetRequest::class, 'recordable');
    }

    // public function recorded_budget_requests() {
    //     return $this->morphedByMany(Requests\BudgetRequest::class, 'requestable');
    // }

    
    public function travel_auth_requests() {
        return $this->hasMany(Requests\TravelAuthRequest::class);
    }

    public function feedbacked_travel_auth_requests() {
        return $this->morphedByMany(Requests\TravelAuthRequest::class, 'recordable');
    }

    // public function recorded_travel_auth_requests() {
    //     return $this->morphedByMany(Requests\TravelAuthRequest::class, 'requestable');
    // }

    public function calendar_events() {
        return $this->hasMany(CalendarEvent::class);
    }

    public function event_types() {
        return $this->hasMany(EventType::class);
    }

    public function employee_to_substitute() {
        return $this->hasMany(Requests\TravelAuthRequest::class, 'employee_to_cover_id');
    }

    public function notifications() {
        return $this->hasMany(Notification::class);
    }

}
