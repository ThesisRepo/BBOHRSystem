<?php

namespace App\Models\Requests;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'leave_type_id',
        'department_id',
        'start_date',
        'end_date',
        'number_of_days',
        'approver_role_id',
        'status_id'
    ];

    public function user() {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function leave_type() {
        return $this->belongsTo(LeaveType::class);
    }

    public function department() {
        return $this->belongsTo(\App\Models\Department::class);
    }

    public function status() {
        return $this->belongsTo(Status::class);
    }

    public function approvers() {
        return $this->morphToMany(\App\Models\User::class, 'recordable')->withTimestamps();
    }

    public function user_requester() {
        return $this->morphToMany(\App\Models\User::class, 'requestable')->withTimestamps();        
    }

    public function user_request() {
        return $this->morphOne(\App\Models\UserRequest::class, 'requestable')->withTimestamps();        
    }

    public function approver_role() {
        return $this->belongsTo(\App\Models\Role::class);
    }
}
