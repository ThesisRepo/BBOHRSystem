<?php

namespace App\Models\Requests;

use Illuminate\Database\Eloquent\Model;

class OvertimeRequest extends Model
{
    protected $fillable = [ 
        'user_id',
        'reason',
        'date',
        'start_time',
        'end_time',
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

    public function user_requester() {
        return $this->morphToMany(\App\Models\User::class, 'requestable')->withTimestamps();        
    }
    
    public function approver_role() {
        return $this->belongsTo(\App\Models\Role::class);
    }
}
