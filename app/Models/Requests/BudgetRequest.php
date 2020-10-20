<?php

namespace App\Models\Requests;

use Illuminate\Database\Eloquent\Model;

class BudgetRequest extends Model
{
    protected $fillable = [ 
        'user_id',
        'description_need',
        'department_id',
        'date',
        'total_amount',
        'details',
        'approver_role_id',
        'status_id'
    ];

    public function user() {
        return $this->belongsTo(\App\Models\User::class);
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

    public function department() {
        return $this->belongsTo(\App\Models\Department::class);
    }
}
