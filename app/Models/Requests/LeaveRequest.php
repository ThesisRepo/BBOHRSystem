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
        'start_date',
        'end_date',
        'reason',
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

    public function status() {
        return $this->belongsTo(Status::class);
    }

    public function approvers() {
        return $this->morphToMany(\App\Models\User::class, 'approved_request_records');
    }
    public function approver_role() {
        return $this->belongsTo(\App\Models\Role::class);
    }
}
